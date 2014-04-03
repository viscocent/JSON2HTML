<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title></title>
</head>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<link href="css/json2html.css" rel="stylesheet">

<body>
<?php $plain_text = $_POST["plain_text"]; ?>
<div class="tool-bar">
	<center>
	<form action="" method="post">
		<label class="sub-title">paste json here:</label>
		<hr>
		<textarea class="json_container" name="plain_text" cols="23" rows="8"><?php echo $plain_text ?></textarea><br>
		<hr>
		<label class="sub-title">display:</label>
		<b></b>
		<hr>
		<div class="panel">
			<label><input type="radio" id="show_html" name="decode_type"> html</label><br>
			<label><input type="radio" id="show_array" name="decode_type"> array</label><br>
		</div>
		<hr>
		<input type="submit" value="Parse JSON" class="plain_button">
		<!-- <input id="show-return" type="button" value="Show Return Code"> -->
		<hr>
	</form>
	</center>
</div>
<div class="html_view">
	<div class="html_decoded">
	<?php
	$itrn = 1;
	function JSON_to_HTML($json, $itrn){
		$itrn++;
		echo "<table class='toggle' id='jstb".$itrn."'>";
		foreach($json as $key=>$value){
			if($value):
				if(is_array($value)):
					echo "<tr><td class='array' id='parent'>{$key}:</td><td>";
					JSON_to_HTML($value,$itrn);
					echo "</td></tr>";
				else:
					if(preg_match('/.png|.gif|.jpg.|jpeg/', $value)):
						echo "<tr><td>".$key.":</td><td class='italic'>".$value."</td></tr>";	
					else:
						echo "<tr><td>".$key.":</td><td>{$value}</td></tr>";	
					endif;
				endif;	
			else:
				echo "<tr><td id='parent' class='field-grey'>".$key.":</td><td class='field-empty'><span class='null'>null</span></td></tr>";		
			endif;
		}
		echo "</table>";
	}

	if(!empty($_POST["plain_text"])){
		$json_raw = $_POST["plain_text"];
		echo "<table class='outer'>";
		$data = json_decode($json_raw, true);
		foreach($data as $key=>$value){
			if($value){
				if(is_array($value)){
					echo "<tr><td  class='array'>".$key.":</td><td  child='".$child."'>";
					JSON_to_HTML($value,$itrn);
					echo "</td></tr>";
				}else{ 
					echo "<tr><td>".$key.":</td><td child='".$child."'>".$value."</td></tr>";		
				}
			}else{
				echo "<tr><td>".$key.":</td><td class='field-empty' child='".$child."'><span class='null'>null</span></td></tr>";
			}
		} 
		echo "</table>";
	}else{
		echo "nothing to parse";
	}
	?>
	</div>
	<div class="array_decoded">
		<?php 
			echo "<pre>";
			echo print_r(json_decode($_POST["plain_text"]));
			echo "</pre>"; 
		?>
	</div>
</div>
</body>
<script type="text/javascript">
	$('.array_decoded').hide();
	$(document).ready(function(){
		$('#show_html').click(function(){
			$('.array_decoded').hide();
			$('.html_decoded').show();
		});
		$('#show_array').click(function(){
			$('.html_decoded').hide();
			$('.array_decoded').show();
		});
	});
</script>
</html>
