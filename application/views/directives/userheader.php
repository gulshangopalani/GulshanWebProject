    <div class="example3">
      <nav class="navbar navbar-inverse navbar-static-top">
        <div class="container-fluid">
           <div class="row">
            <div class="col-sm-3 col-xs-6">
              <div class="navbar-header ">
                 <a id="mobileDemo" class="button-collapse"><i class="fa fa-bars"></i></a>
                 <a class="navbar-brand visible-xs"><img src="app/images/login.png" alt="logo"></a>
                  <a class="navbar-brand hidden-xs"><img src="app/images/login.png" alt="logo"></a>
              </div>
            </div>
           <div class="col-sm-9">
            <div class="row" style="z-index: 999;position: fixed;width: 74%;display: inline;">
              <div class="col-sm-2">
               <!--  {{noti_status}} -->
            <button ng-if="noti_status==1" type="button" class="rate-blink-btn blink" name="changerate" id="result-alert" style="color: white;" ng-click="show_notification()">New Notification</button>
           <!--  <button ng-if="noti_status==0" type="button" class="btn btn-success" name="changerate" id="result-alert" style="color: white;" ng-click="show_notification()">New Notification</button> -->
              </div>
              <div class="col-sm-10">
                <div id="alert-dialogue"></div>
              </div>
            </div>
            <header-notificationuser></header-notificationuser>
          </div>
          <!--/.nav-collapse -->
        </div>
      </div>
        <!--/.container-fluid -->

      </nav>
      <div class="marqueeHead" >
          <div class="moving-div">
          <marquee hspace="0" scrollamount="5" BEHAVIOR="SCROLL" style="font-size:14px;color:#fff;" onmouseover="this.stop();" onmouseout="this.start();">{{diplayMsg}}</marquee>
        </div>
      </div>
      <usersidebar></usersidebar>

    </div>


