<div id="cardDiv">
    <div style="position: relative; padding-top:180px;padding-left:30px;">
        <table class="" style="width:100%;margin-left:100px;" id="cardDetailsTable">
            <tr>
                <td><?php echo CardType::$CARD_TYPE_LIST[$model->visitor_type]; ?></td>
            </tr>
            <tr>
                <td><?php echo $visitorModel->first_name.', '.$visitorModel->last_name ?></td>
            </tr>
            <tr>
                <td><?php 
                    if($visitorModel->company != ''){
                        echo Company::model()->findByPk($visitorModel->company)->name;
                    }   else {
                        echo "Not Available";
                    }
                    ?></td>
            </tr>
            <tr>
                <td><?php echo date('d/m/Y'); ?></td>
            </tr>
        </table>
        
        
    </div>
</div>
<input type="button" class="printCardBtn" value="Print Card" />
