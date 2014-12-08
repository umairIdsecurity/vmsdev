<?php

class UpdateVisitStatusCommand extends CConsoleCommand {

    public function run($args) {
        $this->closeVisit();
        $this->ExpiredVisit();
     
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
