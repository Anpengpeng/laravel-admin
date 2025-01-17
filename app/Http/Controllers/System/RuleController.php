<?php
/**
 * Created by PhpStorm.
 * User: zengfanwei
 * Date: 2018/11/5
 * Time: 11:01
 */

namespace App\Http\Controllers\System;


use App\Components\Common;
use App\Http\Controllers\AuthController;
use App\Model\Rule;
use App\Components\Code;
use Illuminate\Support\Facades\Log;

class RuleController extends AuthController
{
    public function getTreeList()
    {

        $list = Rule::getInstance(Rule::class)->getList($this->request->all());
        $tree = Common::generateRuleTree($list, 0);

        return $this->sendJson([
            'list' => $tree,
            'auth' => [
                'canAdd'    => $this->canAdd(),
                'canEdit'   => $this->canEdit(),
                'canDelete' => $this->canDelete()
            ]
        ]);
    }

    public function getAllRoutes()
    {
        $routes = app()->routes->getRoutes();
        $data = [];
        foreach ($routes as $value) {
            if(!$value->uri || $value->uri === '/') {
                continue;
            }
            $data[] = $value->uri;
        }

        return $this->sendJson($data);
    }

    /**
     * 保存权限
     */
    public function save()
    {
        if(!$this->request->input('id')) {
            $rows = Rule::getInstance(Rule::class)->getRows(['name' => $this->request->input('name')]);
            if(!empty($rows)) {
                return $this->sendError(Code::RULE_EXIST);
            }
        }

        Rule::getInstance(Rule::class)->saveData($this->request->all());

        return $this->sendJson();
    }

    /**
     * 获取详情
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function get()
    {
        $rows = Rule::getInstance(Rule::class)->getRows(['id' => $this->request->input('id')]);
        return $this->sendJson($rows[0] ?? []);
    }

    /**
     * 获取路径详情
     */
    public function getPathInfo()
    {
        $path = $this->request->input('path');
        $list = Rule::getInstance(Rule::class)->getList();

        $newList = $curRow = [];
        foreach ($list as $row) {
            $newList[$row['id']] = $row;
            if($path === $row['name']) {
                $curRow = $row;
            }
        }

        if(empty($curRow)) {
            return $this->sendError(Code::FAIL);
        }

        $data[] = $curRow;
        while (isset($newList[$curRow['pid']])) {
            array_push($data, $newList[$curRow['pid']]);
            $curRow = $newList[$curRow['pid']];
        }

        $data = array_reverse($data);

        return $this->sendJson($data);
    }

    /**
     * 删除记录
     */
    public function delete()
    {
        Rule::getInstance(Rule::class)->deleteRow($this->request->input('id'));
        $this->sendJson();
    }

}
