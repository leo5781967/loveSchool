<!DOCTYPE html>
<?php session_start(); 
		if (empty($_SESSION['user_acc'])){
		die("<a href='..index.html'>請先登入!!!!</a>");
	}
	
	include '../db.php';
	$select=mysqli_query($link,"SELECT * FROM `master_list`");	
	$row=mysqli_num_rows($select);
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>康寧大學-愛校管理系統</title>
        
<!-- 

Sentra Template

https://templatemo.com/tm-518-sentra

-->
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">

        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/fontAwesome.css">
        <link rel="stylesheet" href="css/light-box.css">
        <link rel="stylesheet" href="css/owl-carousel.css">
        <link rel="stylesheet" href="css/templatemo-style.css">
		
		<link href="../css/M-Option.css" rel="stylesheet" type="text/css" media="all" />

        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
		<style>
			@import url(https://fonts.googleapis.com/earlyaccess/cwtexyen.css);
			@import url(//fonts.googleapis.com/earlyaccess/notosanstc.css);
			
			.collapse.in {
				display: block;
				visibility: visible;
			}
			.collapse {
				display: none;
				visibility: hidden;
			}
			
			.table {
				width: 95%;
				font-size:18px;
				border-collapse: collapse;
				text-align: left;
				/*margin: 10px 5px 5px 10px;*/
				cursor: default;
				border: 1px solid #000;
				/*margin-top:20px;*/
				box-shadow: 0px 0px 10px rgba(0,255,255,0.75);
				border: 1px solid rgba(127,255,255,0.75);
				-webkit-box-shadow: 0px 0px 8px rgba(0,255,255,0.75);
				-moz-box-shadow: 0px 0px 8px rgba(0,255,255,0.75);
				box-shadow: 0px 0px 8px #8ca5f7;
			}
			td,td>a {
				font: 15px "微软雅黑", Arial, Helvetica, sans-serif;
				text-align: center;
				padding: 6px 0 6px 0;
				//color: rgba(128,255,255,0.75);
				//text-shadow: 0px 0px 20px rgba(0,255,255,0.75);/*-webkit-filter: drop-shadow(0px 0px 20px rgba(0,255,255,0.95));
				-moz-filter: drop-shadow(0px 0px 20px rgba(0,255,255,0.95));
				-o-filter: drop-shadow(0px 0px 20px rgba(0,255,255,0.95));
				-ms-filter: drop-shadow(0px 0px 20px rgba(0,255,255,0.95));
				filter: drop-shadow(0px 0px 20px rgba(0,255,255,0.95));*/
			}
			.bg {
				display: none;
				position: absolute;
				top: 0%;
				left: 0%;
				width: 100%;
				height: 800%;
				background-color: black;
				z-index: 1001;
				-moz-opacity: 0.7;
				opacity: .70;
				filter: alpha(opacity=70);
			}
			.sidebar-navigation .logo {
				background-color: #3D38C3;
			}
		</style>

        <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
		
		<script src="../js/jquery-3.1.1.min.js"></script>
		<script>
			function aa(pag){

				if(typeof(pag)=='undefined')pag=1;

				var year=document.getElementById("year1").value;

				var dep=document.getElementById("dep").value;

				var grade=document.getElementById("grade").value;

				var name=document.getElementById("name").value;

				var account=document.getElementById("account").value;

				$.ajax({

					url: "test_2.php?p="+pag,

					type:'POST',

					data:{year:year,dep:dep,grade:grade,name:name,account:account},

					success: function(result){

						$("#div1").html(result);

					},

				});

			}

			aa();
			
		</script>
    </head>

<body>


        <header class="nav-down responsive-nav hidden-lg hidden-md">
			
				<button type="button" id="nav-toggle" class="navbar-toggle" data-toggle="collapse" data-target="#main-nav">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					
				</button>
			

				<!--/.navbar-header-->
				
				<div id="main-nav" class="collapse">
					<nav>
						<ul class="nav navbar-nav">
							<li><a href="#top">查看愛校歷史紀錄</a></li>
							<li><a href="#featured">統計學期積欠紀錄</a></li>
							<li><a href="#projects">統計學期愛校紀錄</a></li>
							<li><a href="#video">統計各單位愛校紀錄</a></li>
							<li><a href="#contact">統計事由總人次時數</a></li>
						</ul>
					</nav>
				</div>
		</header>	
		

        <div class="sidebar-navigation hidde-sm hidden-xs">
            <div class="logo">
                <a href="#">愛校管理<em>系統</em></a>
            </div>
            <nav>
                <ul>
                    <li>
                        <a href="#top">
                            <span class="rect"></span>
                            <span class="circle"></span>
                            查看愛校歷史紀錄
                        </a>
                    </li>
                    <li>
                        <a href="#featured">
                            <span class="rect"></span>
                            <span class="circle"></span>
                            統計學期積欠紀錄
                        </a>
                    </li>
                    <li>
                        <a href="#projects">
                            <span class="rect"></span>
                            <span class="circle"></span>
                            統計學期愛校紀錄
                        </a>
                    </li>
                    <li>
                        <a href="#video">
                            <span class="rect"></span>
                            <span class="circle"></span>
                            統計各單位愛校紀錄
                        </a>
                    </li>
                    <li>
                        <a href="#contact">
                            <span class="rect"></span>
                            <span class="circle"></span>
                            統計事由總人次時數
                        </a>
                    </li>
                </ul>
            </nav>
            <ul class="social-icons">
                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                <li><a href="#"><i class="fa fa-rss"></i></a></li>
                <li><a href="#"><i class="fa fa-behance"></i></a></li>
            </ul>
        </div>



		
        <div class="page-content">
		<div id="bg" class='bg' onclick='hide();'></div>
		<div id="table" style="display: none;" class='show'></div>
			<section id="top" class="content-section">
			
                <div class="section-heading">
					<center><h1 style='color:#4B0091;'>查看各科系年級愛校紀錄</h1></center>
                </div>
                <div class="section-content">
					<div class="item item-1">
						<div class="img-fill">
							<div class="image"></div>
							<div class="info">
								<div class="div2">
									
									<div class="main">
										<center>
											</br>
											
											<table style="align:center;border:0;width:80%;">
												<form>
													<tr style='font-size:16px;'>
														
														<td>
														學期：
															<select name="year1" id="year1"  align="center">
																<?php
																$select=mysqli_query($link,"SELECT DISTINCT `semester` FROM `master_list` order by `semester` DESC");
																while($row=mysqli_fetch_assoc($select)){ 
																?>
																<option value="">
																<?php echo $row['semester'];}?>
																</option>
															</select>
														</td>
														<td>
														科系:
															<select name="dep" id="dep"  align="center">
																<option value="">請選擇</option>
																<?php
																$select=mysqli_query($link,"SELECT DISTINCT `stu_dep` FROM `student_information`");
																while($row=mysqli_fetch_assoc($select)){ 
																?>
																<option>
																<?php echo $row['stu_dep'];}?>
																</option>
															</select>
														</td>
														<td>
															年級：
															<select name="grade" id="grade"  align="center">
																<option value="">請選擇</option>
																<?php
																$select=mysqli_query($link,"SELECT DISTINCT `stu_grade` FROM `student_information`  order by `stu_grade` ASC");
																while($row=mysqli_fetch_assoc($select)){ 
																?>
																<option>
																<?php echo $row['stu_grade'];}?>
																</option>
															</select>
														</td>
														<td>
															班級名稱：
															<select name="name" id="name"  align="center">
																<option value="">請選擇</option>
																<?php
																$select=mysqli_query($link,"SELECT DISTINCT `class_name` FROM `student_information`");
																while($row=mysqli_fetch_assoc($select)){ 
																?>
																
																<option>
																<?php echo $row['class_name'];}?>
																</option>
															</select>
														</td>
														<td>
															學號：<input type="text" id="account" name="account" style="height:30px;width:150px">
														</td>
														<td>
															<a href="javascript: aa();" onclick="aa()">
																<input type="button" class="blue" value="查詢">
															</a>
														</td>
														<!--<td>
															<a href="javascript: bb();" onclick="bb()">
																<input type="button" class="red" value="清空查詢">
															</a>
														</td>-->
													</tr>
												</form>
												
											</table>
											</br>
											<div id="div1"></div>
										</center>
									</div>
								</div>
							</div>
						</div>
					</div>
                </div>
            </section>
            <section id="featured" class="content-section">
                <div class="section-heading">
                    <h1>前言<br><em>Preface</em></h1>
                    <p>精油的入浴球讓你睡前放鬆~~
                    <br>滿足視覺與嗅覺的最佳享受!!</p>
                </div>
                <div class="section-content">
					<p style="font-family: 'cwTeXYen', sans-serif;font-size:20px;">近年來人們開始注重生活品質，越來越大的工作壓力更是需要有好的紓壓管道。
					<br><br>
					平時上班的壓力急需紓解，但是外出按摩或SPA長期下來需花費大量金錢。因此除了重視work & life balance之外，如何居家放鬆更是成為現代人不可缺少的必修課題，香氛與泡澡正為專家推薦的居家放鬆首選之一，而入浴球正是結合泡澡與香氛的絕佳產品。
					<br><br>
					將入浴球加入精油，提升氣氛與透過精油功效為使用者放鬆身心，只為提供最溫和、完整的養護，為身心靈提供充滿力量的療癒體驗。</p>
					
                    
                </div>
            </section>
            <section id="projects" class="content-section">
                <div class="section-heading">
                    <h1>商品描述/特寫照<br><em>Product description</em></h1>
                    <p style="font-size:25px;">天然礦物粉於泡澡同時有效保濕、柔嫩全身肌膚， 
                    <br>搭配水溫可加速身體循環，沐浴後散發宜人香氣。</p>
                </div>
                <div class="section-content">
                    <div class="masonry">
                        <div class="row">
                            <div class="item">
                                <div class="col-md-8">
                                    <a href="img/portfolio_7.jpg" data-lightbox="image"><img src="img/portfolio_7.jpg" alt="image 1"></a>
                                </div>
                            </div>
                            <div class="item second-item">
                                <div class="col-md-4">
                                    <a href="img/portfolio_6.jpg" data-lightbox="image"><img src="img/portfolio_6.jpg" alt="image 2"></a>
                                </div>
                            </div>
                            <div class="item">
                                <div class="col-md-4">
                                    <a href="img/portfolio_8.jpg" data-lightbox="image"><img src="img/portfolio_8.jpg" alt="image 3"></a>
                                </div>
                            </div>
                            <div class="item">
                                <div class="col-md-4">
                                    <a href="img/portfolio_10.jpg" data-lightbox="image"><img src="img/portfolio_10.jpg" alt="image 4"></a>
                                </div>
                            </div>
                            <div class="item">
                                <div class="col-md-8">
                                    <a href="img/portfolio_9.jpg" data-lightbox="image"><img src="img/portfolio_9.jpg" alt="image 5"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>            
            </section>
            <section id="video" class="content-section">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-heading">
                            <h1>This is a <em>Video</em> viewing.</h1>
                            <p>手工製作影片</p>
                        </div>
                        <div class="text-content">
                            <p>~~~</p>
                        </div>
                        <div class="accent-button button">
                            <a href="#blog">Continue Reading</a>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="box-video">
                            <div class="bg-video" style="background-image: url(https://unsplash.imgix.net/photo-1425036458755-dc303a604201?fit=crop&fm=jpg&q=75&w=1000);">
                                <div class="bt-play">Play</div>
                            </div>
                            <div class="video-container">
                                <iframe hidden="hidden" width="100%" height="520" src="https://www.youtube.com/embed/j-_7Ub-Zkow?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen="allowfullscreen"></iframe>
								
								<iframe width="100%" height="520" src="https://www.youtube.com/embed/fuj5O-LQAIE" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="allowfullscreen"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <section id="contact" class="content-section">
                <div id="map">
                
                	<!-- How to change your own map point
                           1. Go to Google Maps
                           2. Click on your location point
                           3. Click "Share" and choose "Embed map" tab
                           4. Copy only URL and paste it within the src="" field below
                    -->
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3613.768823858346!2d121.60786221484277!3d25.07582338395278!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3442acbec1350919%3A0xbc3d8e37b330b2b7!2z5bq35a-n5aSn5a245Y-w5YyX5qCh5Y2A!5e0!3m2!1szh-TW!2stw!4v1602232429506!5m2!1szh-TW!2stw" width="100%" height="400px" frameborder="0" style="border:0" allowfullscreen></iframe>
					
                </div>
                <div id="contact-content">
                    <div class="section-heading">
                        <h1>Contact<br><em>B.RUYU</em></h1>
                        <p>本網站由[康寧電子商務部門]維護，任何意見或問題請洽 e-mail：sec@ukn.edu.tw
                        <br>台北總部：114 台北市內湖區康寧路三段75巷137號　電話： 0800-870-890</p>
                        
                    </div>
                    <div class="section-content">
                        <form id="contact" action="#" method="post">
                            <div class="row">
                                <div class="col-md-4">
                                  <fieldset>
                                    <input name="name" type="text" class="form-control" id="name" placeholder="Your name..." required="">
                                  </fieldset>
                                </div>
                                <div class="col-md-4">
                                  <fieldset>
                                    <input name="email" type="email" class="form-control" id="email" placeholder="Your email..." required="">
                                  </fieldset>
                                </div>
                                 <div class="col-md-4">
                                  <fieldset>
                                    <input name="subject" type="text" class="form-control" id="subject" placeholder="Subject..." required="">
                                  </fieldset>
                                </div>
                                <div class="col-md-12">
                                  <fieldset>
                                    <textarea name="message" rows="6" class="form-control" id="message" placeholder="Your message..." required=""></textarea>
                                  </fieldset>
                                </div>
                                <div class="col-md-12">
                                  <fieldset>
                                    <button type="submit" id="form-submit" class="btn">Send Message Now</button>
                                  </fieldset>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
            <section class="footer">
                <p>Copyright &copy; 2019 Company Name 
                
                . Design: TemplateMo</p>
            </section>
        </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

    <script src="js/vendor/bootstrap.min.js"></script>
    
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>

    <script>
        // Hide Header on on scroll down
        var didScroll;
        var lastScrollTop = 0;
        var delta = 5;
        var navbarHeight = $('header').outerHeight();

        $(window).scroll(function(event){
            didScroll = true;
        });

        setInterval(function() {
            if (didScroll) {
                hasScrolled();
                didScroll = false;
            }
        }, 250);

        function hasScrolled() {
            var st = $(this).scrollTop();
            
            // Make sure they scroll more than delta
            if(Math.abs(lastScrollTop - st) <= delta)
                return;
            
            // If they scrolled down and are past the navbar, add class .nav-up.
            // This is necessary so you never see what is "behind" the navbar.
            if (st > lastScrollTop && st > navbarHeight){
                // Scroll Down
                $('header').removeClass('nav-down').addClass('nav-up');
            } else {
                // Scroll Up
                if(st + $(window).height() < $(document).height()) {
                    $('header').removeClass('nav-up').addClass('nav-down');
                }
            }
            
            lastScrollTop = st;
        }
    </script>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>

</body>
</html>