<nav class="navbar-default navbar-static-side" role="navigation">
    <div  style="" class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu" data-toggle="tooltip">
			
			<li class="nav-header text-center">
				<div class="dropdown profile-element">
					<strong class="font-bold text-white">
						<?php echo get_session('UNombre'); ?>
					</strong>
				</div>
				<div class="logo-element">
					<?php echo iniciales( get_session('UNombre') ); ?>
				</div>
			</li>
			
			<?php if(is_permitido(null,'dashboard','index')) { ?>
				<li <?php if (nvl($modulo)=='dashboard' ) echo 'class="active"'; ?> >
					<a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-home"></i> <span class="nav-label">Inicio</span></a>
				</li>
			<?php } ?>
			
			<?php if(is_permitido(null,'recibos','index')) { ?>
				<li <?php if (nvl($modulo)=='recibos' ) echo 'class="active"'; ?> >
					<a href="<?php echo base_url('recibos/index/mes'); ?>"><i class="fa fa-file-text"></i> <span class="nav-label">Recibos</span></a>
				</li>
			<?php } ?>
			
			<?php if(is_permitido(null,'percepciones','index')) { ?>
				<li <?php if (nvl($modulo)=='percepciones' ) echo 'class="active"'; ?> >
					<a href="<?php echo base_url('percepciones/index/anio'); ?>"><i class="fa fa-money"></i> <span class="nav-label">Percepciones</span></a>
				</li>			
			<?php } ?>
			
			<?php if(is_permitido(null,'circular','index')) { ?>
				<li <?php if (nvl($modulo)=='circular' ) echo 'class="active"'; ?> >
					<a href="<?php echo base_url('circular'); ?>"><i class="fa fa-envelope"></i> <span class="nav-label">Circulares</span></a>
				</li>			
			<?php } ?>
			
			<?php if( is_permitido(null,'personal','index') or is_permitido(null,'fump','revisar') or is_permitido(null,'fump','alta') ) { ?>
			<li class="<?php if( nvl($modulo)=='personal' or nvl($modulo)=='fump' or nvl($modulo)=='alta') echo "active"; ?>">
				<a href="#"><i class="fa fa-users"></i> <span class="nav-label">Personal</span> <span class="fa arrow"></span></a>
				<ul class="nav nav-second-level collapse" style="height: 0px;">
					<?php if(is_permitido(null,'personal','index')) { ?>
					<li <?php if( nvl($modulo) == 'personal' ) echo 'class="active"'; ?>><a href='<?php echo base_url("personal");?>' >Personal</a></li>
					<?php } ?>
					<?php if(is_permitido(null,'fump','revisar')) { ?>
					<li <?php if( nvl($modulo) == 'fump' ) echo 'class="active"'; ?>><a href='<?php echo base_url("fump/revisar");?>' >Revisión FUMP</a></li>
					<?php } ?>
					<?php if(is_permitido(null,'fump','alta')) { ?>
					<li <?php if( nvl($modulo) == 'alta' ) echo 'class="active"'; ?>><a href='<?php echo base_url("fump/alta");?>' >Alta Nomina</a></li>
					<?php } ?>
				</ul>
			</li>
			<?php } ?>
			
			<?php if( is_permitido(null,'incidencias','index') or is_permitido(null,'incidencias','autorizar') or is_permitido(null,'incidencias','registrar') ) { ?>
			<li class="<?php if( nvl($modulo)=='index' or nvl($modulo)=='autorizar' or nvl($modulo)=='registrar') echo "active"; ?>">
				<a href="#"><i class="fa fa-file-text"></i> <span class="nav-label">Incidencias</span> <span class="fa arrow"></span></a>
				<ul class="nav nav-second-level collapse" style="height: 0px;">
					<?php if(is_permitido(null,'incidencias','index')) { ?>
					<li <?php if( nvl($modulo) == 'index' ) echo 'class="active"'; ?>><a href='<?php echo base_url("incidencias");?>' >Mis Incidencias</a></li>
					<?php } ?>
					<?php if(is_permitido(null,'incidencias','autorizar')) { ?>
					<li <?php if( nvl($modulo) == 'autorizar' ) echo 'class="active"'; ?>><a href='<?php echo base_url("incidencias/autorizar");?>' >Autorizar</a></li>
					<?php } ?>
					<?php if(is_permitido(null,'incidencias','registrar')) { ?>
					<li <?php if( nvl($modulo) == 'registrar' ) echo 'class="active"'; ?>><a href='<?php echo base_url("incidencias/registrar");?>' >Registrar</a></li>
					<?php } ?>
				</ul>
			</li>
			<?php } ?>
			
			<?php if( is_permitido(null,'reportes','rep_fump') ) { ?>
			<li class="<?php if( nvl($modulo)=='rep_fump') echo "active"; ?>">
				<a href="#"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Reportes</span> <span class="fa arrow"></span></a>
				<ul class="nav nav-second-level collapse" style="height: 0px;">
					<?php if(is_permitido(null,'reportes','rep_fump')) { ?>
					<li <?php if( nvl($modulo) == 'rep_fump' ) echo 'class="active"'; ?>><a href='<?php echo base_url("reportes/rep_fump");?>' >FUMP</a></li>
					<?php } ?>
				</ul>
			</li>
			<?php } ?>
			
			<?php if( is_permitido(null,'horasClase','index') or is_permitido(null,'profesiograma','index') or is_permitido(null,'periodos','index') or is_permitido(null,'grupos','index') or is_permitido(null,'plantilla','index') or is_permitido(null,'nuevaplantilla','index')) { ?>
			<li class="<?php if(nvl($modulo)=='horasClase' or nvl($modulo)=='profesiograma' or nvl($modulo)=='periodos' or nvl($modulo)=='grupos' or nvl($modulo)=='plantilla' or nvl($modulo)=='nuevaplantilla' or nvl($modulo)=='terna' ) echo "active"; ?>">
				<a href="#"><i class="fa fa-building-o"></i> <span class="nav-label">Docencia</span> <span class="fa arrow"></span></a>
				<ul class="nav nav-second-level collapse" style="height: 0px;">
					<?php if(is_permitido(null,'profesiograma','index')) { ?>
					<li <?php if( nvl($modulo) == 'profesiograma' ) echo 'class="active"'; ?>><a href='<?php echo base_url("profesiograma");?>' >Profesiograma</a></li>
					<?php } ?>
					<?php if(is_permitido(null,'periodos','index')) { ?>
					<li <?php if( nvl($modulo) == 'periodos' ) echo 'class="active"'; ?>><a href='<?php echo base_url("periodos");?>' >Periodo Escolar</a></li>
					<?php } ?>
					<?php if(is_permitido(null,'grupos','index')) { ?>
					<li <?php if( nvl($modulo) == 'grupos' ) echo 'class="active"'; ?>><a href='<?php echo base_url("grupos");?>' >Grupos</a></li>
					<?php } ?>
					<?php if(is_permitido(null,'horasClase','index')) { ?>
					<li <?php if( nvl($modulo) == 'horasClase' ) echo 'class="active"'; ?>><a href='<?php echo base_url("horasClase");?>' >Horas Clase Asignadas</a></li>
					<?php } ?>
					<?php if(is_permitido(null,'plantilla','index')) { ?>
					<li <?php if( nvl($modulo) == 'plantilla' ) echo 'class="active"'; ?>><a href='<?php echo base_url("plantilla");?>' >Plantilla</a></li>
					<?php } ?>
					<?php if(is_permitido(null,'nuevaplantilla','index')) { ?>
					<li <?php if( nvl($modulo) == 'nuevaplantilla' ) echo 'class="active"'; ?>><a href='<?php echo base_url("nuevaplantilla");?>' >Nueva Plantilla</a></li>
					<?php } ?>
				</ul>
			</li>
			<?php } ?>
			
			<?php if( is_permitido(null,'plantel','index') or is_permitido(null,'autoridad','index') or is_permitido(null,'tabulador','index') or is_permitido(null,'incidencias','cincidencias') ) { ?>
			<li class="<?php if( nvl($modulo)=='plantel' or nvl($modulo)=='autoridad' or nvl($modulo)=='tabulador' or nvl($modulo)=='cincidencias') echo "active"; ?>">
				<a href="#"><i class="fa fa-bars"></i> <span class="nav-label">Catalogos</span> <span class="fa arrow"></span></a>
				<ul class="nav nav-second-level collapse" style="height: 0px;">
					<?php if(is_permitido(null,'plantel','index')) { ?>
					<li <?php if( nvl($modulo) == 'plantel' ) echo 'class="active"'; ?>><a href='<?php echo base_url("plantel");?>' >Planteles</a></li>
					<?php } ?>
					<?php if(is_permitido(null,'autoridad','index')) { ?>
					<li <?php if( nvl($modulo) == 'autoridad' ) echo 'class="active"'; ?>><a href='<?php echo base_url("autoridad");?>' >Autoridades</a></li>
					<?php } ?>
					<?php if(is_permitido(null,'tabulador','index')) { ?>
					<li <?php if( nvl($modulo) == 'tabulador' ) echo 'class="active"'; ?>><a href='<?php echo base_url("tabulador");?>' >Tabulador</a></li>
					<?php } ?>
					<?php if(is_permitido(null,'incidencias','cincidencias')) { ?>
					<li <?php if( nvl($modulo) == 'cincidencias' ) echo 'class="active"'; ?>><a href='<?php echo base_url("incidencias/cincidencias");?>' >Incidencias</a></li>
					<?php } ?>
				</ul>
			</li>
			<?php } ?>
			
			<li class="<?php if(nvl($modulo)=='permisos' or $modulo=='configurar' or nvl($modulo)=='cambiar') echo "active"; ?>">
				<a href="#"><i class="fa fa-cog"></i> <span class="nav-label">Sistema</span> <span class="fa arrow"></span></a>
				<ul class="nav nav-second-level collapse" style="height: 0px;">
					<?php if(is_permitido(null,'permisos','index')) { ?>
					<li <?php if( nvl($modulo) == 'permisos' ) echo 'class="active"'; ?>><a href='<?php echo base_url("permisos");?>' >Permisos</a></li>
					<?php } ?>
					<?php if(is_permitido(null,'configurar','index')) { ?>
					<li <?php if( nvl($modulo) == 'configurar' ) echo 'class="active"'; ?>><a href='<?php echo base_url("configurar");?>' >Configurar</a></li>
					<?php } ?>
					<?php if( is_permitido( get_session('OldRol'), 'cambiar', 'index') ) { ?>
					<li <?php if( nvl($modulo) == 'cambiar' ) echo 'class="active"'; ?>><a href='<?php echo base_url("cambiar");?>' >Cambiar</a></li>
					<?php } ?>
					
					<?php if(! get_session('psw') ){ ?>
					<li><a href="#" class="open" data-target="#modal_configuracion" data-toggle="modal">Perfil</a></li>
					<?php } ?>
					<li><a href='<?php echo base_url("login/logout");?>' confirm="¿Estas seguro de salir?" >Salir</a></li>
				</ul>
			</li>
			
		</ul>
	</div>
</nav>
<script type="text/javascript">
	$(document).ready(function() {
		var tamano_menu = $('.sidebar-collapse').width();
		
		if( tamano_menu <= 70 )
		{
			$( 'li' ).attr("data-toggle", "tooltip" );
			$( 'ul' ).attr("data-toggle", "tooltip" );
		}
		
		if( tamano_menu == 220 )
		{
			$('li').removeAttr("data-toggle");
			$('ul').removeAttr("data-toggle");
		}
		
		$( '.navbar-minimalize').click(function()
		{
			var barra_navegacion = $( '.sidebar-collapse' ).width();
			var ancho_ventana = $( window ).width();
			
			if( ancho_ventana < 768 )
			{
				$( 'li' ).attr("data-toggle", "tooltip" );
				$( 'ul' ).attr("data-toggle", "tooltip" );
			}
			
			if( ancho_ventana >= 768 && barra_navegacion == 220)
			{
				$( 'li' ).attr("data-toggle", "tooltip" );
				$( 'ul' ).attr("data-toggle", "tooltip" );
			}
			
			if( ancho_ventana >= 768 && barra_navegacion == 70 )
			{
				$('li').removeAttr("data-toggle");
				$('ul').removeAttr("data-toggle");
			}
		});
	});
	/* Function para tooltip*/
	
	$(document).ready(function() {
		
		$("[data-toggle=tooltip]").tooltip();
	});
	
	/* # FIN de Function para tooltip*/
</script>
