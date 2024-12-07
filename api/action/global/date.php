
        <span style="font-size:14px;font-weight:bold;">
            <?php
            if (!isset($decrypted_array['ACCESS'])) {
              header("Location:/#");
            }
                date_default_timezone_set('Asia/Manila');
                echo $date = date('D | F j, Y')."&nbsp;|&nbsp; ";
            ?>
        </span>

        <span id="time" style="font-size:14px;font-weight:bold;"></span>
        
        <script type="text/javascript" charset="utf-8">
          function myClock() {
            setTimeout(function() {
              const d = new Date();
              const n = d.toLocaleTimeString();
              document.getElementById("time").innerHTML = n;
              myClock();
            }, 1000)
          }
          myClock();
        </script>
