<?php
global $os,$site;


if(! $os->isLogin() )
{
    header("Location: ".$site['url']."login");
    exit();
}else{

    $studentId=$os->userDetails['studentId'];
    $name=$os->userDetails['name'];



    $query_res="select * from book_issue where member_table='student' and  member_table_id='$studentId'  and is_return!=1 ";
    $query_res_rs=$os->mq($query_res);



    ?>
    <div class="uk-margin">
        <h3> Issued Books </h3>
        <table class="uk-table uk-table-small uk-table-responsive uk-table-striped">
            <thead>
            <tr>
                <th>Book Name</th>
                <th>Author Name</th>
                <th>Issued on</th>
                <th>Renew Date</th>
                <th>Remark</th>
            </tr>
            </thead>
            <tbody>

            <?
            while($rec=$os->mfa($query_res_rs))
            {
                $book_id=$rec['book_id'];
                $book= $os->rowByField('',$tables='book',$fld='book_id',$fldVal=$book_id,$where='',$orderby='');

                $issue_date = $rec['issue_date'];
                $renew_date = date('Y-m-d', strtotime($rec['issue_date']. ' + 14 days'));
                ?>
                <tr>

                    <td class="uk-text-bold"><? echo $book['name'] ?>  </td >
                    <td>
                        <span class="uk-text-muted uk-hidden@m">Author : </span>
                        <?=$book["author"]; ?>
                    </td >
                    <td><span class="uk-text-muted uk-hidden@m">Issued on : </span>
                        <? echo $os->showDate($issue_date); ?>
                    </td >
                    <td>
                        <span class="uk-text-muted uk-hidden@m">Renew Date : </span>
                        <? echo $os->showDate($renew_date); ?>
                    </td >
                    <td>
                        <?
                        $diff = date_diff(date_create(date("Y-m-d")), date_create($renew_date));
                        $days =  (int)$diff->format("%R%a");

                        if($days>0&&4>$days){
                            echo "<span class='uk-text-small uk-text-warning'>".$days." days left for renew</span>";
                        } elseif ($days<0){
                            echo "<span class='uk-text-small uk-text-danger'>Renew date expired</span>";
                        } else{
                            echo "<span class='uk-text-small uk-text-green'>".$days."  days left for renew</span>";
                        }
                        ?>
                    </td>

                </tr>
            <?} ?>
            </tbody>
        </table>
    </div>

    <?
    $query_res="select * from book_issue where member_table='student' and  member_table_id='$studentId'  and is_return=1 ";
    $query_res_rs=$os->mq($query_res);

    ?>

    <div class="uk-margin">
        <h3> Returned Book </h3>
        <table class="uk-table uk-table-small uk-table-responsive uk-table-striped">
            <thead>
            <tr>
                <th>Book Name</th>
                <th>Author Name</th>
                <th>Issued on</th>
                <th>Returned on</th>
            </tr>
            </thead>
            <tbody>

            <?
            while($rec=$os->mfa($query_res_rs))
            {
                $book_id=$rec['book_id'];

                $book= $os->rowByField('',$tables='book',$fld='book_id',$fldVal=$book_id,$where='',$orderby='');

                ?>

                <tr>

                    <td class="uk-text-bold"><? echo $book['name'] ?>  </td >
                    <td>
                        <span class="uk-text-muted uk-hidden@m">Author : </span>
                        <?=$book["author"]; ?>
                    </td >
                    <td>
                        <span class="uk-text-muted uk-hidden@m">Issued On : </span>
                        <? echo $os->showDate($rec['issue_date']); ?>
                    </td >
                    <td>
                        <span class="uk-text-muted uk-hidden@m">Returned on : </span>
                        <? echo $os->showDate($rec['return_date']); ?>
                    </td >

                </tr>
            <?} ?>
            </tbody>
        </table>
    </div >
<?} ?>

