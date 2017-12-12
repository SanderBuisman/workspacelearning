<?php


namespace App\Tips;


use App\Cohort;

class TipService
{

    /**
     * Create a tip from basic data
     * Tip can be used in next creation step
     * @param array $tipData
     * @return Tip
     */
    public function createTip(array $tipData) {
        $tip = new Tip;
        $tip->name = $tipData['name'];
        $tip->showInAnalysis = isset($tipData['showInAnalysis']);

        return $tip;
    }

    public function coupleStatistic(Tip $tip, Statistic $statistic, array $tipCoupledStatisticData) {
        $tip->statistics()->attach($statistic, $tipCoupledStatisticData);
    }

    public function decoupleStatistic(Tip $tip, $tipCoupledStatisticId) {
        return $tip->statistics()->wherePivot('id', '=', $tipCoupledStatisticId)->detach();
    }

    /**
     * Create a new tip based on the data passed
     *
     * @param Tip $tip
     * @param array $data
     * @return Tip
     */
    public function setTipData(Tip $tip, array $data) {
        $tip->name = $data['name'];
        $tip->tipText = $data['tipText'];
        $tip->showInAnalysis = isset($data['showInAnalysis']);

        $tip->save();

        return $tip;
    }

    /**
     * Enable this tip for selected cohorts
     *
     * @param Tip $tip
     * @param array $data
     * @return Tip
     */
    public function enableCohorts(Tip $tip, array $data)
    {
        $tip->load('enabledCohorts');

        // Delete all current attached cohorts
        $tip->enabledCohorts()->detach();
        // Enable/attach all selected cohorts
        $tip->enabledCohorts()->attach($data['enabledCohorts']);

        return $tip;
    }

    /**
     * Couple the selected statistics to the Tip
     *
     * @param Tip $tip
     * @param array $statisticsData
     * @return void
     */
    public function coupleStatistics(Tip $tip, array $statisticsData) {
        foreach($statisticsData as $statisticId => $couplingData) {
            $statistic = (new Statistic)->findOrFail($statisticId);
            $tip->statistics()->attach($statistic, $couplingData);
        }
    }
}