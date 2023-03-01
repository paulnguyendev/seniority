<?php
namespace App\Helpers;
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
        $model = new AgentModel();
        $items = $model::descendantsOf($agentId)->whereNotNull($column);
        $items = $items ? $items->toArray() : [];
        return $items;
    }
    public static function getAgentInfo($agentId) {
        $model = new AgentModel();
        $agent = $model::find($agentId);
        return $agent;
    }
    public static function getNumberProductOfAgent($agentId)
    {
        $agent = self::getAgentInfo($agentId);
        $result = $agent->products()->where('status', 'active')->count();
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
        $levelIdsOfChilds = array_column($childsOfAgent, 'license_level_id');
        $levelIdsOfChilds = array_count_values($levelIdsOfChilds);
        $result = [];
        foreach ($items as $key => $item) {
            # Get data item
            $levelId = $item['id'];
            $levelName = $item['name'] ?? "";
            $levelIsBreak = $item['is_break'];
            $levelCondition = $item['condition_level'] ?? [];
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
                    $itemNumber['info']['number_product'] = $numberProductOfAgent;
                    $itemNumber['info']['number_agent'] = count($childsOfAgent);
                    $result[] = $itemNumber;
                }
            }
        }
        $result = end($result);
        return $result['info'] ?? [];
    }
    public static function updateLevel($agentId) {
        $checkLevelId = null;
        $checkLevelInfo = self::checkLevel($agentId);
        $agentInfo = self::getAgentInfo($agentId);
        $agentEmail = $agentInfo['email'] ?? "";
        $agentType = $agentInfo['type'] ?? "";
        $licenseLevelId = $agentInfo['license_level_id'] ?? "";
        $agentLevelId  = $agentType == 'licensed' ? $licenseLevelId : "";
        $note = null;
        if($checkLevelInfo) {
            $checkLevelId = $checkLevelInfo['level_id'];
            $checkLevelName = $checkLevelInfo['level_name'];
            if($checkLevelId != $agentLevelId) {
                $note =  "Level of {$agentEmail} change form {$agentLevelId} to {$checkLevelId}";
            }
        }
        echo $note;
        echo '<pre>';
        print_r($checkLevelInfo);
        echo '</pre>';
    }
}
