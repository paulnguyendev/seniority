<?php
namespace App\Helpers;
use App\Models\AgentLicenseModel;
use App\Models\LevelNonLicencedModel;
use App\Models\LicenseTransactionModel;
use App\Models\ProductModel;
use Modules\Agent\Entities\AgentLicense;
use Modules\Agent\Entities\AgentModel;
use Modules\LevelLicenced\Entities\LevelLicencedModel;
class Level
{
    public static function getLicenseLevels()
    {
        $model = new LevelLicencedModel();
        $items = $model::with('conditionLevel')->get();
        $items = $items ? $items->toArray() : [];
        $items = array_map(function ($item) {
            $condition_level = isset($item['condition_level']) ? $item['condition_level'] : [];
            $item['condition_level'] = array_shift($condition_level);
            return $item;
        }, $items);
        return $items;
    }
    public static function getChildsOfAgent($agentId, $column = "license_level_id")
    {
        $model = new AgentLicenseModel();
        $items = $model::descendantsOf($agentId);
        $items = $items ? $items->toArray() : [];
        return $items;
    }
    public static function getLatestChildsOfAgent($agentId, $number = 5)
    {
        $model = new AgentLicenseModel();
        $items = $model::reversed()->descendantsOf($agentId)->take($number);
        $items = $items ? $items->toArray() : [];
        return $items;
    }
    public static function getParentsOfAgent($agentId)
    {
        $model = new AgentLicenseModel();
        $items = $model::ancestorsOf($agentId);
        $items = $items ? $items->toArray() : [];
        return $items;
    }
    public static function getAgentInfo($agentId)
    {
        $model = new AgentLicenseModel();
        $agent = $model::find($agentId);
        return $agent;
    }
    public static function getNumberProductOfAgent($agentId)
    {
        $agent = self::getAgentInfo($agentId);
        $result = $agent->products()->where('status', 'active')->count();
        return $result;
    }
    public static function getProductsOfAgent($agentId, $not_id = "")
    {
        $agent = self::getAgentInfo($agentId);
        $result = $agent->products()->where('status', 'active');
        if($not_id) {
            $result = $result->where('id','!=',$not_id);
        }
        $result = $result->get();
        return $result;
    }
    public static function checkLevel($agentId)
    {
        $items = self::getLicenseLevels();
        $numbersOfLevels = [];
        $numberProductOfAgent = self::getNumberProductOfAgent($agentId);
        #Childs of Agent
        $childsOfAgent = self::getChildsOfAgent($agentId);
        # Level ids of childs
        $levelIdsOfChilds = [];
        $levelIdsOfChilds = array_column($childsOfAgent, 'level_id');
        $levelIdsOfChilds = array_count_values($levelIdsOfChilds);
        $result = [];
        foreach ($items as $key => $item) {
            # Get data item
            $levelId = $item['id'];
            $levelName = $item['name'] ?? "";
            $levelIsBreak = $item['is_break'];
            $levelCondition = $item['condition_level'] ?? [];
            $personalPayout = $item['personal_payout'] ?? 0;
            $teamOverrides = $item['team_overrides'] ?? 0;
            # Get Data Of Level ids
            $dataOfLevelIds = isset($levelIdsOfChilds[$levelId]) ? $levelIdsOfChilds[$levelId] : 0;
            # Update numbersOfLevels
            $numbersOfLevels[$key]['level_id'] = $levelId;
            $numbersOfLevels[$key]['number_agent'] = $dataOfLevelIds;
            $numbersOfLevels[$key]['number_product'] = $numberProductOfAgent;
            $numbersOfLevels[$key]['level_name'] = $levelName;
            # Get data levelCondition
            $conditionDirectLevelId = $levelCondition['direct_level_id'] ?? null;
            $conditionNumberAgent = $levelCondition['number_agent'] ?? 0;
            $conditionNumberProduct = $levelCondition['number_product'] ?? 0;
            foreach ($numbersOfLevels as $itemNumber) {
                if (
                    $itemNumber['level_id'] == $conditionDirectLevelId &&
                    $itemNumber['number_agent'] >= $conditionNumberAgent &&
                    $itemNumber['number_product'] >= $conditionNumberProduct
                ) {
                    $itemNumber['info']['level_id'] = $levelId;
                    $itemNumber['info']['level_name'] = $levelName;
                    $itemNumber['info']['is_break'] = $levelIsBreak;
                    $itemNumber['info']['personal_payout'] = $personalPayout;
                    $itemNumber['info']['team_overrides'] = $teamOverrides;
                    $itemNumber['info']['number_product'] = $numberProductOfAgent;
                    $itemNumber['info']['number_agent'] = count($childsOfAgent);
                    $result[] = $itemNumber;
                }
            }
        }
        $result = end($result);
        return $result['info'] ?? [];
    }
    public static function getLevelInfo($levelId, $key = "", $type = "license")
    {
        $model = $type == 'license' ? new LevelLicencedModel() : new LevelNonLicencedModel();
        $item = $model::find($levelId);
        $resultKey = isset($item[$key]) ? $item[$key] : "";
        $result = $key ? $resultKey : $item;
        return $result;
    }
    public static function updateLevel($agentId, $product_id = "")
    {
        $checkLevelId = null;
        $checkLevelInfo = self::checkLevel($agentId);
        $agentInfo = self::getAgentInfo($agentId);
        $agentEmail = $agentInfo['email'] ?? "";
        $agentType = $agentInfo['type'] ?? "";
        $agentLevelId = $agentInfo['level_id'] ?? "";
        $agentModel = new AgentLicenseModel();
        $productModel = new ProductModel();
        $note = "No Change Level";
        $agentLevelName = null;
        if ($checkLevelInfo) {
            $checkLevelId = $checkLevelInfo['level_id'];
            $agentLevelName = self::getLevelInfo($agentLevelId, 'name');
            $checkLevelName = $checkLevelInfo['level_name'];
            $checkLevelIsBreak = $checkLevelInfo['is_break'] ?? 0;
            if ($checkLevelId != $agentLevelId) {
                $note =  "Ambassador {$agentEmail} change form {$agentLevelName} to {$checkLevelName}";
                $agentModel->saveItem(['id' => $agentId, 'level_id' => $checkLevelId], ['task' => 'edit-item']);
                if ($checkLevelIsBreak == 1) {
                    $agentModel->saveItem(['id' => $agentId, 'parent_id' => NULL], ['task' => 'edit-item']);
                    $agentModel::fixTree();
                }
                // if($product_id) {
                //     $productModel->saveItem(['id' => $product_id, 'status' => 'complete'],['task' => 'edit-item']);
                // }
            }
        }
        $result['note'] = $note;
        $result['current_level'] = $agentLevelName;
        $result['checkLevelInfo'] = $checkLevelInfo;
        return $result;
    }
    public static function addLicenseTransaction($data)
    {
        $totalPersonalPayout = 0;
        $totalTeamOverRides = 0;
        $productId = $data['productId'] ?? "";
        $total = $data['total'] ?? 0;
        $agentId = $data['agentId'] ?? "";
        $agentInfo = $agentId ? self::getAgentInfo($agentId) : [];
        $levelId = $agentInfo['level_id'] ?? "";
        $levelInfo = $levelId ?  self::getLevelInfo($levelId, "") : [];
        $personalPayout = $levelInfo['personal_payout'] ?? 0;
        $teamOverrides = $levelInfo['team_overrides'] ?? 0;
        #_Add Personal Payout
        $totalPersonalPayout = round($personalPayout * $total / 100);
        $params = [];
        $params['product_id'] = $productId;
        $params['agent_id'] = $agentId;
        $params['total'] = $totalPersonalPayout;
        $params['type'] = 'in';
        $params['status'] = 'active';
        $params['created_at'] = date('Y-m-d H:i:s');
        $model = new LicenseTransactionModel();
        $checkTransaction = null;
        $checkTransaction = $model->getItem(['product_id' => $productId, 'agent_id' => $agentId], ['task' => 'check_exist']);
        if (!$checkTransaction) {
            $model->saveItem($params, ['task' => 'add-item']);
        }
        #_Add Team Overrides [Get parents by agent Id]
        $parents = self::getParentsOfAgent($agentId);
        if (count($parents) > 0) {
            foreach ($parents as $parent) {
                $parentLevelId = $parent['level_id'] ?? "";
                $parentLevelInfo = $parentLevelId ?  self::getLevelInfo($parentLevelId, "") : [];
                $parentTeamOverrides = $parentLevelInfo['team_overrides'] ?? 0;
                if ($parentTeamOverrides > 0) {
                    $totalTeamOverRides = round($parentTeamOverrides * $total / 100);
                    $params['total'] = $totalTeamOverRides;
                    $model->saveItem($params, ['task' => 'add-item']);
                }
            }
        }
        return $parents;
    }
}
