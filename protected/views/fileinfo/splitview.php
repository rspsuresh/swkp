<div class="md-card">
    <div class="md-card-content">
        <div class="uk-grid" data-uk-grid-margin="">
        <div class="uk-width-medium-1-1">
            <table class="uk-table" style=" word-wrap:break-word;
              table-layout: fixed;">
                <thead>
                <tr>
                    <th>Category</th>
                    <th>Pages</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if ($model) {
                    foreach ($model as $value) {
                        echo '<tr>';
                       echo '<td>'.(isset($value->Category->ct_cat_name)?$value->Category->ct_cat_name:""). '</td>';
                        echo '<td>' . $value->fp_page_nums . '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr>';
                    echo '<td>No Result Found </td>';
                    echo '</tr>';
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>