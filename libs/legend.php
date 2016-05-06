<?php include('light_header.php'); ?>
<div id='legend'>
    <p>
    <?php 
	if(!check_login($conn, $page.BASE_DIR.'list.php')){
	    echo "<a class='btn btn-default btn-xs' href='".BASE_DIR."login.php'><span class='glyphicon glyphicon-user'></span> Login</a>";
	}
    ?>
    <a class="btn btn-default btn-xs" href='<?php echo BASE_DIR; ?>list.php'><span class="glyphicon glyphicon-list"></span> See All Posts</a>
    <span class="glyphicon glyphicon-collapse-down pull-right" title="Hide Legend" id="hide"></span>
    </p>
    <table>
        <tr>
            <td colspan=2>Neighborhood Colors</td><td colspan=2>Tree Colors</td>
        </tr>
        <tr>
            <td><img src='<?php echo BASE_DIR; ?>pictures/light.png' /></td>
            <td>Lighter - Less Stories</td>
            <td><img src="<?php echo BASE_DIR; ?>pictures/t_light.png" /></td>
            <td>Lighter - Less Stories</td>
        </tr>
        <tr>
            <td><img src="<?php echo BASE_DIR; ?>pictures/dark.png" /></td>
            <td>Darker - More Stories</td>
            <td><img src="<?php echo BASE_DIR; ?>pictures/t_dark.png" /></td>
            <td>Darker - More Stories</td>
        </tr>
    </table>
</div>
<script>
var hidden = false;
$("#hide").click(function(){
    if(hidden){
        $("#legend").animate({
            bottom: "+=160"
        }, 250, function(){
            $("#hide").removeClass("glyphicon-collapse-up").addClass("glyphicon-collapse-down");
            $("#hide").prop('title', "Hide Legend");
            $("#hide").focus();
            hidden = false;
        });
    } else {
        $("#legend").animate({
            bottom: "-=160"
        }, 250, function(){
            $("#hide").removeClass("glyphicon-collapse-down").addClass("glyphicon-collapse-up");
            $("#hide").prop('title', "Show Legend");
            $("#hide").focus();
            hidden = true;
        });
    }
});
</script>
