<?php
$enquiryArr = json_decode($model->eq_description, true);
$enquiryArrCnt = count($enquiryArr);
?>
<div class="md-card">
    <div class="md-card-content">
        <div class="uk-grid" data-uk-grid-margin>
            <div class="uk-width-1-1">
                <div class="uk-overflow-container">
                    <table class="uk-table uk-table-align-vertical">
                        <thead>
                            <tr>
                                <th>File IN</th>
                                <th>File OUT</th>
                                <th>Tat Time</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 0; $i < $enquiryArrCnt; $i++) { ?>
                                <tr>
                                    <td class="uk-text-large uk-text-nowrap"><?php echo $enquiryArr[$i]['cd_file_in_format']; ?></td>
                                    <td class="uk-text-nowrap"><?php echo $enquiryArr[$i]['cd_file_out_format']; ?></td>
                                    <td><?php echo $enquiryArr[$i]['cd_hours']; ?></td>
                                    <td class="uk-text-nowrap"><span class="uk-badge uk-badge-success"><?php echo "$ ".$enquiryArr[$i]['price']; ?></span></td>
                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>