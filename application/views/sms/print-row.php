<?php
class SMS{
    public function smsBal($route=4){
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.msg91.com/api/balance.php?authkey=224991AuVykO8pSsz5b4313bf&type=$route",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_SSL_VERIFYHOST => 0,
          CURLOPT_SSL_VERIFYPEER => 0,
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
          return "cURL Error #:" . $err;
        } else {
          return $response;
        }
    }
}
if($action == "smsBal"){
    ?>
    <table class="table table-bordered">
            <tr>
                <th>1</th>
                <th>Transactional</th>
                <td id="trans">
                    <?php
                        $sendSMS = new SMS();
                        echo $sendSMS->smsBal(4);
                    ?>
                </td>
            </tr>
            <tr>
                <th>2</th>
                <th>Permotional</th>
                <td id="promo">
                    <?php
                        
                        echo $sendSMS->smsBal(1);
                    ?>
                </td>
            </tr>
            <tr>
                <th>3</th>
                <th>OTP</th>
                <td id="otp">
                   <?php
                        
                        echo $sendSMS->smsBal(106);
                    ?>
                </td>
            </tr>
        </table>
    <?
}

?>