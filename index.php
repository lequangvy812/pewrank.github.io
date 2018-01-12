
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf_name" content="csrf_test_name">
    <meta name="csrf_hash" content="b4493fc81221e608e1d766ca37358500">
    
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="cache-control" content="cache">
    <meta http-equiv="content-language" content="en">
	    
    <title>Dumucer's Ranking System</title>
    <link rel="dns-prefetch" href="//cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link rel="dns-prefetch" href="//ajax.googleapis.com">
    <link rel="dns-prefetch" href="//graph.facebook.com">
    <link rel="dns-prefetch" href="//scontent.xx.fbcdn.net">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto&amp;subset=vietnamese">
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <!--[if lt IE 9]>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
    .avatar {
      border-radius: 50%;
      width: 40px;
      height: 40px;
    }
    /* fade image in after load */
    .lazyload,
    .lazyloading {
      opacity: 0;
    }
    .lazyloaded {
      opacity: 1;
      transition: opacity 300ms;
    }
    td.fix{
      text-align: center;
      vertical-align: middle;
    }
    </style>
  </head>
  <body>
      <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-91482018-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-91482018-1');
</script>
    <div class="container w6">
	<?php
	$rank = json_decode(file_get_contents("rank.json"), true);
	$rankCount = count($rank);
	
	$rankforNumber = ($rankCount >= 20) ? 20 : $rankCount;
	?>
	<div class="row">
        <div class="col-sm-12">
		<center>Có <strong><?php echo $rankCount ?></strong> thành viên đã được xếp hạng</center></br>
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title"><i class="fa fa-search" aria-hidden="true"></i> Check Rank</h3>
            </div>
			<div class="panel-body">
				<form id="searchRank" method="post">
					<div class="input-group">
						<input class="form-control" type="text" name="user" placeholder="Username hoặc id facebook">
						<span class="input-group-btn"><button type="submit" id="searchButton" class="btn btn-default">Tìm kiếm</button></span>
					</div>
				</form>
				<div id="rankResult" style="display: none;">
					Dumucer : <strong><span id="name">{{s.name}}</span></strong><br />
					Xếp hạng : <strong><span id="rank">{{s.rank}}</span></strong><br />
					Pew Point : <strong><span id ="point">{{s.point}}</span></strong><br />
				</div>
				<div id="rankErrors" style="color: #a94442; display: none;">{{s.message}}</div>
			</div>
		  </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title"><span class="glyphicon glyphicon-stats" aria-hidden="true"></span> Top 20 Dumucer</h3>
            </div>
            <table class="table table-bordered table-hover table-striped">
              <thead>
                <tr class="bg-info">
                  <th class="text-center">#</th>
                  <th class="text-center">Dumucer</th>
                  <th class="text-center">Bài Đăng</th>
                  <th class="text-center">Pew Point</th>
                </tr>
              </thead>
				<?php for($i = 0; $i < $rankforNumber; $i++): ?>
				<tbody>
				<td class="fix" style="vertical-align: middle;text-align: center;"><?php echo $i+1 ?></td>
				<td><img class="avatar lazyload" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="https://graph.facebook.com/<?php echo $rank[$i]['id'] ?>/picture?width=40&height=40" alt="" width="40px" height="40px"> <a href="https://wwww.facebook.com/<?php echo $rank[$i]['id'] ?>"><?php echo $rank[$i]['name'] ?></a></td>
				<td class="fix" style="vertical-align: middle;text-align: center;"><?php echo $rank[$i]['post'] ?></td>
				<td class="fix" style="vertical-align: middle;text-align: center;"><?php echo $rank[$i]['points'] ?></td>
				</tbody>
				<?php endfor; ?>
            </table>
			</div>
        </div>
      </div>
    </div>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/3.0.0/lazysizes.min.js"></script>
	<script>
	$("#searchRank").on('submit',(function(e) {
		e.preventDefault();
		$.ajax({
			url: "rep?to=web",
			type: "POST",
			data:  new FormData(this),
			dataType: "json",
			contentType: false,
			cache: false,
			processData:false,
			beforeSend: function () {
				$('#searchButton').text('Đang xử lý...').prop('disabled', true)
			},
			success: function(s) {
				$('#searchButton').text('Tìm kiếm').prop('disabled', false)
				if(s.error == false){
					$("#rankErrors").hide()
					$("#rankResult").show()
					$("#rankResult").find('#name').text(s.name)
					$("#rankResult").find('#rank').text(s.rank)
					$("#rankResult").find('#point').text(s.point)
				} else if(s.error == true){
					$("#rankResult").hide()
					$("#rankErrors").text(s.message).show()
				}
			},
			error: function(){
				$("#rankErrors").text("Đã xảy ra lỗi!").show()
			}
	   });
	}));
	</script>
  </body>
</html>