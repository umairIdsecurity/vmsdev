<?php

class UpdateVisitStatusCommand extends CConsoleCommand {

    public function run($args) {
        //$this->closeVisit();
        //$this->ExpiredVisit();
        $this->closeOneDayVisits();
        $this->closeMultiDayVisits();
    }

    public function closeOneDayVisits() {
        /**
         * 24 Hour card type is issued for 24h
         * update visit status to close and card status to return if
         * between current time and checkout time is greater than 24 hour and if visit status is
         * still active and card status is still active
         */
        $visit = new Visit;
        $visit->updateOneDayVisitsToClose();
        $visit->updateSameDayVisitsToExpired();
    }

    public function closeMultiDayVisits() {
        /* EVIC card type is issued Strictly for 28 days
         * update visit status to close and card status to return if
         * current date is greater than date check out and if visit status is still active
         * and card status is still active
         */
        $visit = new Visit;
        $visit->updateMultiDayVisitsToClose();
    }

    public function closeVisit() {
        /* update status to close if
          card date out is not equal to current date and if current date is greater than date out
          and if card status is active -- 3 and visit status is not equals  3 closed
         */

        $visit = new Visit();
        $visit->updateVisitsToClose();
    }

    public function ExpiredVisit() {
        /* update status to expired if
          current day is greater than expiration day and card type is multiday visitor and 
         * visit status is active and card status is active
         */
        $visit = new Visit();
        $visit->updateVisitsToExpired();
    }

}

?>
