<?php 
$output = '
<div class="ln-fx">{{repeater}}</div>';
$css = '
.testimonial-mod{
    margin:{{margin_css}};
   	padding:{{padding_css}};
}
{{module-class}} .ln-fx{
	width:100%;
    display: flex;
    flex-wrap: wrap;
}
.testi-mod{
    -ms-flex: 1 0 100%;
    margin: 0 3% 2% 0px;
    width: 31.3%;
    position: relative;
    color: #26292c;
}
.testi-cont{
    width: 100%;
    padding: 30px 30px 25px 30px;
    font-size: 18px;
    background: #f4f4f4;
    position: relative;
}
{{module-class}} .testi-cont p{
    margin-bottom:5px
}
.testi-cont:after{
	content:"";
	width: 0;
	height: 0;
	border-style: solid; 
	border-width: 20px 20px 0 20px;
	border-color: #f4f4f4 transparent transparent transparent;
	bottom:-20px;
	position:absolute;
}
.testi-mod:nth-child(3),.testi-mod:nth-child(6),.testi-mod:nth-child(9){
    margin-right:0;
}
.auth-info{
	width:100%;
	display:inline-block;
	margin-top: 35px;
	margin-left:15px;
}
.auth-img{
	float:left;
	margin-right:15px;
}
.auth-img amp-img{
	border-radius:50%;
    max-width:50px;
    max-height:50px;
}
.auth-cntn{
    float: left;
    font-size: 13px;
    color: #888e94;
    line-height: 1.8;
    font-weight: 500;
    margin-top: 2px;
}
.auth-cntn h5{
	font-weight:500;
}
.auth-cntn span{
	font-weight:normal;
}
';
return array(
		'label' =>'Testimonial',
		'name' =>'testimonial-mod',
		'default_tab'=> 'customizer',
		'tabs' => array(
              'customizer'=>'Content',
              'design'=>'Design',
              'advanced' => 'Advanced'
            ),
		'fields' => array(
						array(
								'type'		=>'color-picker',
								'name'		=>"font_color_picker",
								'label'		=>'Color',
								'tab'		=>'design',
								'default'	=>'#333',
								'content_type'=>'css'
							),
						array(
								'type'		=>'spacing',
								'name'		=>"margin_css",
								'label'		=>'Margin',
								'tab'		=>'advanced',
								'default'	=>array(
													'left'=>'0px',
													'right'=>'0px',
													'top'=>'10px',
													'bottom'=>'10px'
													),
								'content_type'=>'css',
							),
							array(
								'type'		=>'spacing',
								'name'		=>"padding_css",
								'label'		=>'Padding',
								'tab'		=>'advanced',
								'default'	=>array(
													'left'=>'0px',
													'right'=>'0px',
													'top'=>'0px',
													'bottom'=>'0px'
												),
								'content_type'=>'css',
							),

			),
		'front_template'=> $output,
		'front_css'=> $css,
		'repeater'=>array(
          'tab'=>'customizer',
          'fields'=>array(
		                array(		
		 						'type'		=>'text-editor',		
		 						'name'		=>"content",		
		 						'label'		=>'Testimonial',
		           				 'tab'     =>'customizer',
		 						'default'	=>'Testimonial',	
		           				'content_type'=>'html',
	 					),
	 					array(		
		 						'type'		=>'upload',		
		 						'name'		=>"img_upload",		
		 						'label'		=>'Avatar',
		           				 'tab'     =>'customizer',
		 						'default'	=>'',	
		           				'content_type'=>'html',
	 						),
	 					array(
				               'type'  =>'text',
				              'name'=>"image_height",
				              'label'=>"Image height",
				              'tab'  => "customizer",
				              'default'=>'50',
				              'content_type'=>'html',
				              ),
				        array(
				               'type'  =>'text',
				              'name'=>"image_width",
				              'label'=>"Image width",
				              'tab'  => "customizer",
				              'default'=>'50',
				              'content_type'=>'html',
				              ),
						array(		
		 						'type'		=>'text',		
		 						'name'		=>"content_title",		
		 						'label'		=>'Author Name',
		           				'tab'       =>'design',
		 						'default'	=>'Name',	
		           				'content_type'=>'html',
	 						),
						array(		
		 						'type'		=>'text',		
		 						'name'		=>"auth_desig",		
		 						'label'		=>'Designation',
		           				'tab'       =>'design',
		 						'default'	=>'Designation',	
		           				'content_type'=>'html',
	 						),
                
              ),
          'front_template'=>
        '<div class="testi-mod">
			<div class="testi-cont">
				{{content}}
			</div>
			<div class="auth-info">
				<div class="auth-img">
					<amp-img src="{{img_upload}}" width="{{image_width}}" height="{{image_height}}"></amp-img>
				</div>
				<div class="auth-cntn">
					<h5>{{content_title}}</h5>
					<span>{{auth_desig}}</span>
				</div>
			</div>
		</div> '
          ),
	);

?>