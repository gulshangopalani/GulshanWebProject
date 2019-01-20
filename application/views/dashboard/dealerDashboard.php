<div class="col-sm-12 col-md-12 padding">
<!-- Market table -->
<div class="table-responsive">
    <div class="widget-content">
          
          <table class="table table-striped table-bordered my-market">
            <thead>
              <tr>
                <th>Match Name</th>
                <th class="text-right">Team A</th>
                <th class="text-right">Team B</th>
                <th class="text-right">Draw</th>
              </tr>
            </thead>
            <tbody>
             <tr ng-repeat="mtchRs in matchResult">
                <td data-label="Match Name"><a href="" ui-sref="dealerDashboard.Matchodds({MatchId: mtchRs.matchId,MarketId:mtchRs.marketId,matchName:mtchRs.matchName,date:mtchRs.date})">{{mtchRs.matchName}}</a></td>
                <td data-label="Team A" class="text-left">
                  <span class="team-lft-txt">{{mtchRs.teamAt |limitTo: 6 }}</span>
                  <strong class="text-right"> 
                      <span ng-if="mtchRs.TeamA>0" style="color:#50bd00;"> {{mtchRs.TeamA|number:2}}</span>
                      <span ng-if="mtchRs.TeamA<0" style="color:RED;">{{mtchRs.TeamA|number:2}}</span>
                      <span ng-if="mtchRs.TeamA==0" style="color:Black;">{{mtchRs.TeamA|number:2}}</span>
                  </strong>
                </td>
         
                <td data-label="Team B" class="text-left">
                      <span class="team-lft-txt">{{mtchRs.teamBt| limitTo: 6 }} </span> 
                      <strong class="text-right">
                        <span ng-if="mtchRs.TeamB>0" style="color:#50bd00;">{{mtchRs.TeamB|number:2}}</span>
                        <span ng-if="mtchRs.TeamB<0" style="color:RED;">{{mtchRs.TeamB|number:2}}</span>
                        <span ng-if="mtchRs.TeamB==0" style="color:Black;">{{mtchRs.TeamB|number:2}}</span>
                      </strong>
                </td>
         
                <td data-label="Draw" class="text-left">
                   <span class="team-lft-txt">{{mtchRs.teamCt }} &emsp;</span>
                    <strong class="text-right"> 
                      <span ng-if="mtchRs.theDraw>0" style="color:#50bd00;">{{mtchRs.theDraw|number:2}}</span>
                      <span ng-if="mtchRs.theDraw<0" style="color:RED;">{{mtchRs.theDraw|number:2}}</span>
                      <span ng-if="mtchRs.theDraw==0" style="color:Black;">{{mtchRs.theDraw|number:2}}</span>
                    </strong>
                </td>
              </tr>
              </tbody>
            </table>
          
        </div> <!-- /widget-content -->
</div>  
</div>
