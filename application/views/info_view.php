<div class="theme-config noimprimir">
    <div class="theme-config-box">
        <div class="spin-icon">
			<span class="badge badge-warning pull-right"><?php echo count($percepciones)+count($circulares)+count($recibos)+count($fumps); ?></span>
            <i class="fa fa-bell fa-spin-"></i>
        </div>
		
        <div class="skin-setttings">
            <div class="title">NOTIFICACIONES</div>
			
			<div class="ibox float-e-margin setings-item default-skin">
				<span class="skin-name">
					<a class="collapse-link s-skin-0">
						<span>(<?php echo count($percepciones); ?>) Percepciones</span>
						<!--div class="ibox-tools pull-right">
							<i class="fa fa-chevron-down"></i>
						</div-->
					</a>
				</span>
				<div class="ibox-content" style="display: none;">
					<?php foreach($percepciones as $key => $val){ ?>
					<div class="setings-item">
						<?php						
						$PDClave_skip = $this->encrypt->encode($val['PDClave']);
						$ruta = "percepciones/index/$PDClave_skip/".rand(100000,10000000000);
						?>
						<a href="<?php echo base_url($ruta); ?>">
							<?php echo "Folio: [".folio($val['PDClave'])."] - ".$val['UNombre']; ?>
						</a>
					</div>
					<?php } ?>
				</div>
			</div>
			
			<div class="ibox float-e-margin setings-item blue-skin">
				<span class="skin-name">
					<a class="collapse-link s-skin-1">
						<span>(<?php echo count($circulares); ?>) Circulares</span>
						<!--div class="ibox-tools pull-right">
							<i class="fa fa-chevron-down"></i>
						</div-->
					</a>
				</span>
				<div class="ibox-content" style="display: none;">
					
					<div class="setings-item">
						<span>
							<a href="<?php echo base_url("circular/");?>">
							Ver Circulares
							</a>
						</span>
					</div>
				</div>
			</div>
			
			<div class="ibox float-e-margin setings-item yellow-skin">
				<span class="skin-name">
					<a class="collapse-link s-skin-3">
						<span>(<?php echo count($recibos); ?>) Recibos</span>
						<!--div class="ibox-tools pull-right">
							<i class="fa fa-chevron-down"></i>
						</div-->
					</a>
				</span>
				<div class="ibox-content" style="display: none;">
					<?php foreach($recibos as $key => $val){ ?>
					<div class="setings-item">
						<span>
							<a href="<?php echo base_url("recibos/index/".$this->encrypt->encode($val['AClave'])); ?>">
							<?php echo $val['ANombre']; ?>
							</a>
						</span>
					</div>
					<?php } ?>
				</div>
			</div>
			
			<div class="ibox float-e-margin setings-item default-skin">
				<span class="skin-name">
					<a class="collapse-link s-skin-0">
						<span>(<?php echo count($fumps); ?>) FUMP</span>
						<!--div class="ibox-tools pull-right">
							<i class="fa fa-chevron-down"></i>
						</div-->
					</a>
				</span>
				<div class="ibox-content" style="display: none;">
					<?php 
					foreach($fumps as $key => $val){ 
					$FClave_skip = $this->encrypt->encode($val['FClave']);
					?>
					<div class="setings-item text-left">
						<span>
							<a href="<?php echo base_url("fump/ver/$FClave_skip/null/$nivel_skip"); ?>">
							<b>FUMP:<?php echo folio($val['FClave']); ?></b> <br />
							<small><?php echo $val['FNombre']." ".$val['FApellido_pat']." ".$val['FApellido_mat']; ?></small>
							<small><?php echo $val['FPlantel']; ?></small>
							</a>
						</span>
					</div>
					<?php } ?>
				</div>
			</div>
			
        </div>
    </div>
</div>

<script>
    // Config box

    // Enable/disable fixed top navbar
    $('#fixednavbar').click(function (){
        if ($('#fixednavbar').is(':checked')){
            $(".navbar-static-top").removeClass('navbar-static-top').addClass('navbar-fixed-top');
            $("body").removeClass('boxed-layout');
            $("body").addClass('fixed-nav');
            $('#boxedlayout').prop('checked', false);

            if (localStorageSupport){
                localStorage.setItem("boxedlayout",'off');
            }

            if (localStorageSupport){
                localStorage.setItem("fixednavbar",'on');
            }
        } else{
            $(".navbar-fixed-top").removeClass('navbar-fixed-top').addClass('navbar-static-top');
            $("body").removeClass('fixed-nav');
            $("body").removeClass('fixed-nav-basic');
            $('#fixednavbar2').prop('checked', false);

            if (localStorageSupport){
                localStorage.setItem("fixednavbar",'off');
            }

            if (localStorageSupport){
                localStorage.setItem("fixednavbar2",'off');
            }
        }
    });

    // Enable/disable fixed top navbar
    $('#fixednavbar2').click(function (){
        if ($('#fixednavbar2').is(':checked')){
            $(".navbar-static-top").removeClass('navbar-static-top').addClass('navbar-fixed-top');
            $("body").removeClass('boxed-layout');
            $("body").addClass('fixed-nav').addClass('fixed-nav-basic');
            $('#boxedlayout').prop('checked', false);

            if (localStorageSupport){
                localStorage.setItem("boxedlayout",'off');
            }

            if (localStorageSupport){
                localStorage.setItem("fixednavbar2",'on');
            }
        } else {
            $(".navbar-fixed-top").removeClass('navbar-fixed-top').addClass('navbar-static-top');
            $("body").removeClass('fixed-nav').removeClass('fixed-nav-basic');
            $('#fixednavbar').prop('checked', false);

            if (localStorageSupport){
                localStorage.setItem("fixednavbar2",'off');
            }
            if (localStorageSupport){
                localStorage.setItem("fixednavbar",'off');
            }
        }
    });

    // Enable/disable fixed sidebar
    $('#fixedsidebar').click(function (){
        if ($('#fixedsidebar').is(':checked')){
            $("body").addClass('fixed-sidebar');
            $('.sidebar-collapse').slimScroll({
                height: '100%',
                railOpacity: 0.9
            });

            if (localStorageSupport){
                localStorage.setItem("fixedsidebar",'on');
            }
        } else{
            $('.sidebar-collapse').slimscroll({destroy: true});
            $('.sidebar-collapse').attr('style', '');
            $("body").removeClass('fixed-sidebar');

            if (localStorageSupport){
                localStorage.setItem("fixedsidebar",'off');
            }
        }
    });

    // Enable/disable collapse menu
    $('#collapsemenu').click(function (){
        if ($('#collapsemenu').is(':checked')){
            $("body").addClass('mini-navbar');
            SmoothlyMenu();

            if (localStorageSupport){
                localStorage.setItem("collapse_menu",'on');
            }

        } else{
            $("body").removeClass('mini-navbar');
            SmoothlyMenu();

            if (localStorageSupport){
                localStorage.setItem("collapse_menu",'off');
            }
        }
    });

    // Enable/disable boxed layout
    $('#boxedlayout').click(function (){
        if ($('#boxedlayout').is(':checked')){
            $("body").addClass('boxed-layout');
            $('#fixednavbar').prop('checked', false);
            $('#fixednavbar2').prop('checked', false);
            $(".navbar-fixed-top").removeClass('navbar-fixed-top').addClass('navbar-static-top');
            $("body").removeClass('fixed-nav');
            $("body").removeClass('fixed-nav-basic');
            $(".footer").removeClass('fixed');
            $('#fixedfooter').prop('checked', false);

            if (localStorageSupport){
                localStorage.setItem("fixednavbar",'off');
            }

            if (localStorageSupport){
                localStorage.setItem("fixednavbar2",'off');
            }

            if (localStorageSupport){
                localStorage.setItem("fixedfooter",'off');
            }


            if (localStorageSupport){
                localStorage.setItem("boxedlayout",'on');
            }
        } else{
            $("body").removeClass('boxed-layout');

            if (localStorageSupport){
                localStorage.setItem("boxedlayout",'off');
            }
        }
    });

    // Enable/disable fixed footer
    $('#fixedfooter').click(function (){
        if ($('#fixedfooter').is(':checked')){
            $('#boxedlayout').prop('checked', false);
            $("body").removeClass('boxed-layout');
            $(".footer").addClass('fixed');

            if (localStorageSupport){
                localStorage.setItem("boxedlayout",'off');
            }

            if (localStorageSupport){
                localStorage.setItem("fixedfooter",'on');
            }
        } else{
            $(".footer").removeClass('fixed');

            if (localStorageSupport){
                localStorage.setItem("fixedfooter",'off');
            }
        }
    });

    // SKIN Select
    $('.spin-icon').click(function (){
        $(".theme-config-box").toggleClass("show");
    });

    // Default skin
    $('.s-skin-0').click(function (){
        $("body").removeClass("skin-1");
        $("body").removeClass("skin-2");
        $("body").removeClass("skin-3");
    });

    // Blue skin
    $('.s-skin-1').click(function (){
        $("body").removeClass("skin-2");
        $("body").removeClass("skin-3");
        $("body").addClass("skin-1");
    });

    // Inspinia ultra skin
    $('.s-skin-2').click(function (){
        $("body").removeClass("skin-1");
        $("body").removeClass("skin-3");
        $("body").addClass("skin-2");
    });

    // Yellow skin
    $('.s-skin-3').click(function (){
        $("body").removeClass("skin-1");
        $("body").removeClass("skin-2");
        $("body").addClass("skin-3");
    });

    if (localStorageSupport){
        var collapse = localStorage.getItem("collapse_menu");
        var fixedsidebar = localStorage.getItem("fixedsidebar");
        var fixednavbar = localStorage.getItem("fixednavbar");
        var fixednavbar2 = localStorage.getItem("fixednavbar2");
        var boxedlayout = localStorage.getItem("boxedlayout");
        var fixedfooter = localStorage.getItem("fixedfooter");

        if (collapse == 'on'){
            $('#collapsemenu').prop('checked','checked')
        }
        if (fixedsidebar == 'on'){
            $('#fixedsidebar').prop('checked','checked')
        }
        if (fixednavbar == 'on'){
            $('#fixednavbar').prop('checked','checked')
        }
        if (fixednavbar2 == 'on'){
            $('#fixednavbar2').prop('checked','checked')
        }
        if (boxedlayout == 'on'){
            $('#boxedlayout').prop('checked','checked')
        }
        if (fixedfooter == 'on') {
            $('#fixedfooter').prop('checked','checked')
        }
    }
</script>
<style type="text/css">
.skin-setttings .ibox {
    margin-bottom: 0px; 
}	
.skin-setttings .setings-item {
    padding: 10px 0px;
}

.skin-setttings .ibox-content {
    background-color: rgba(0, 0, 0, 0);
}
@media print { 
	.noimprimir{display:none} 
}
</style>