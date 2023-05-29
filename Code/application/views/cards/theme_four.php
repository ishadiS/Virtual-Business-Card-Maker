<?php $this->load->view('cards/style'); ?>
<link rel="stylesheet" href="<?=base_url('assets/css/cards/theme-four.css')?>">
</head>
<body>
	<div class="container">
        
		<div class="row d-flex justify-content-center">
			<div class="col-md-5 p-0">
                <div class="card shadow m-0 mt-1 p-3 py-4">
                    <div class="text-center">
                        <img src="<?=isset($meta_image)?htmlspecialchars($meta_image):''?>" alt="<?=isset($card['title'])?htmlspecialchars($card['title']):''?>" class="card-profile-image rounded-circle">
                        <h3 class="mt-2"><?=isset($card['title'])?htmlspecialchars($card['title']):''?></h3>
                        <h6 class="mt-1 font-weight-normal clearfix"><?=isset($card['sub_title'])?htmlspecialchars($card['sub_title']):''?></h6> 
                        <span class="mt-4"><?=isset($card['description'])?htmlspecialchars($card['description']):''?></span>
                        <hr>
                        
                        <?php
                            $social_options = (isset($card['social_options']) && $card['social_options'] != '')?json_decode($card['social_options'],true):'';
                        ?>

                        <ul class="contact-details">

                            <?php if(isset($social_options['mandatory']) && isset($social_options['mandatory']['mobile']) && $social_options['mandatory']['mobile'] != ''){ ?>
                            <li>
                                <a href="tel:<?=htmlspecialchars($social_options['mandatory']['mobile'])?>" class="media contact-details-item">
                                <span class="mr-3 icon-circle"><i class="fa fa-phone m-0"></i></span>
                                <h6 class="mt-0 mb-0 text-left"><?=htmlspecialchars($social_options['mandatory']['mobile'])?></h6></a>
                            </li>
                            <?php } ?>

                            <?php if(isset($social_options['mandatory']) && isset($social_options['mandatory']['email']) && $social_options['mandatory']['email'] != ''){ ?>
                                <li>
                                    <a href="mailto:<?=htmlspecialchars($social_options['mandatory']['email'])?>" class="media contact-details-item">
                                    <span class="mr-3 icon-circle"><i class="fa fa-envelope m-0"></i></span>
                                    <h6 class="mt-0 mb-0 text-left"><?=htmlspecialchars($social_options['mandatory']['email'])?></h6></a>
                                </li>
                            <?php } ?>

                            <?php if(isset($social_options['mandatory']) && isset($social_options['mandatory']['whatsapp']) && $social_options['mandatory']['whatsapp'] != ''){ ?>
                            <li>
                                <a href="https://wa.me/<?=htmlspecialchars($social_options['mandatory']['whatsapp'])?>" target="_blank" class="media contact-details-item">
                                <span class="mr-3 icon-circle"><i class="fab fa-whatsapp m-0"></i></span>
                                <h6 class="mt-0 mb-0 text-left"><?=$this->lang->line('whatsapp')?htmlspecialchars($this->lang->line('whatsapp')):'WhatsApp'?></h6></a>
                            </li>
                            <?php } ?>

                            <?php if(isset($social_options['mandatory']) && isset($social_options['mandatory']['website']) && $social_options['mandatory']['website'] != ''){ ?>
                            <li>
                                <a href="<?=htmlspecialchars($social_options['mandatory']['website'])?>" target="_blank" class="media contact-details-item">
                                <span class="mr-3 icon-circle"><i class="fa fa-globe m-0"></i></span>
                                <h6 class="mt-0 mb-0 text-left"><?=htmlspecialchars($social_options['mandatory']['website'])?></h6></a>
                            </li>
                            <?php } ?>

                            <?php if(isset($social_options['mandatory']) && isset($social_options['mandatory']['address']) && $social_options['mandatory']['address'] != ''){ ?>
                            <li>
                                <a href="<?=(isset($social_options['mandatory']['address_url']) && $social_options['mandatory']['address_url'] != '')?htmlspecialchars($social_options['mandatory']['address_url']):'#'?>" <?=(isset($social_options['mandatory']['address_url']) && $social_options['mandatory']['address_url'] != '')?'target="_blank"':''?> class="media contact-details-item">
                                <span class="mr-3 icon-circle"><i class="fa fa-map-marker m-0"></i></span>
                                <h6 class="mt-0 mb-0 text-left"><?=htmlspecialchars($social_options['mandatory']['address'])?></h6></a>
                            </li>
                            <?php } ?>

                            <?php if(($card['id'] == 1 || ($this->data['card_plan_modules'] && $this->data['card_plan_modules']['custom_fields'])) && isset($social_options['optional']) && $social_options['optional'] != ''){
                                foreach($social_options['optional']['icon'] as $key_icon => $icon){ ?>
                                <?php
                                    foreach($social_options['optional']['text'] as $key_text => $text){ if($key_icon == $key_text){ ?>
                                    <?php
                                        foreach($social_options['optional']['url'] as $key_url => $url){  if($key_icon == $key_url){ if((isset($url) && $url != '') || (isset($text) && $text != '')){ ?>
                                        <li>
                                            <a href="<?=(isset($url) && $url != '')?htmlspecialchars($url):'#'?>" <?=(isset($url) && $url != '')?'target="_blank"':''?> class="media contact-details-item">
                                            <span class="mr-3 icon-circle"><i class="m-0 <?=(isset($icon) && $icon != '')?htmlspecialchars($icon):'fa fa-hand-holding-heart'?>"></i></span>
                                            <h6 class="mt-0 mb-0 text-left"><?=(isset($text) && $text != '')?htmlspecialchars($text):((isset($url) && $url != '')?htmlspecialchars($url):'')?></h6></a>
                                        </li>
                                    <?php } } } ?>
                                <?php } } ?>
                            <?php } } ?>

                        </ul>
                        <hr>
                        <div class="social-buttons mt-3"> 
                            <a id="download-file" download="<?=isset($card['title'])?htmlspecialchars($card['title']):''?>.vcf" href="#" target="_blank" class="btn btn-sm btn-icon icon-left btn-outline-dark col-md-5 mt-1 mr-1 ml-1"><i class="fas fa-download"></i> <?=$this->lang->line('add_to_phone_book')?htmlspecialchars($this->lang->line('add_to_phone_book')):'Add to Phone Book'?></a>
                            <a data-toggle="modal" data-target="#socialShare" href="#" class="btn btn-sm btn-icon icon-left btn-outline-dark col-md-5 mt-1 mr-1 ml-1"><i class="fas fa-share-alt"></i> <?=$this->lang->line('share')?htmlspecialchars($this->lang->line('share')):'Share'?></a>
                        </div>

                    </div>
                </div>
            </div>
		</div>

        <?php if(($card['id'] == 1 || ($this->data['card_plan_modules'] && $this->data['card_plan_modules']['products_services'])) && isset($products) && $products != ''){ ?>
        <div class="row d-flex justify-content-center">
			<div class="col-md-5 p-0">
                <div class="card m-0 mt-1">
                    <div class="card-header d-flex justify-content-center p-0">
                    <h4><?=$this->lang->line('products_services')?htmlspecialchars($this->lang->line('products_services')):'Products/Services'?></h4>
                    </div>
                    <?php foreach($products as $product){ ?>
                        <div class="col-md-12">
                            <article class="article article-style-b border rounded mb-3">
                                <div class="article-header">
                                    <div class="article-image" style="background-image: url('<?=$product['image']!=""?base_url("assets/uploads/product-image/".$product['image']):''?>');">
                                    </div>
                                    <?php if($product['price'] != 0){ ?>
                                    <div class="article-badge">
                                        <div class="article-badge-item bg-primary"><?=$this->lang->line('price')?htmlspecialchars($this->lang->line('price')):'Price'?>: <?=$product['price']?></div>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="article-details">
                                    <div class="article-title">
                                    <h2><a href="<?=$product['url']!=""?htmlspecialchars($product['url']):'#'?>" <?=$product['url']=="" || $product['url']=="#" || $product['url']=="#enquiryform"?'':'target="_blank"'?>><?=htmlspecialchars($product['title'])?></a></h2>
                                    </div>
                                    <p><?=htmlspecialchars($product['description'])?></p>
                                    <div class="article-cta">
                                    <a href="<?=$product['url']!=""?htmlspecialchars($product['url']):'#'?>" <?=$product['url']=="" || $product['url']=="#" || $product['url']=="#enquiryform"?'':'target="_blank"'?>><?=$this->lang->line('enquiry')?htmlspecialchars($this->lang->line('enquiry')):'Enquiry'?> <i class="fas fa-chevron-right"></i></a>
                                    </div>
                                </div>
                            </article>
                        </div>
                    <?php } ?>
                </div>
            </div>
		</div>
        <?php } ?>
        
        <?php if(($card['id'] == 1 || ($this->data['card_plan_modules'] && $this->data['card_plan_modules']['portfolio'])) && isset($portfolio) && $portfolio != ''){ ?>
        <div class="row d-flex justify-content-center">
			<div class="col-md-5 p-0">
                <div class="card m-0 mt-1">
                    <div class="card-header d-flex justify-content-center p-0">
                        <h4><?=$this->lang->line('portfolio')?htmlspecialchars($this->lang->line('portfolio')):'Portfolio'?></h4>
                    </div>
                    <?php foreach($portfolio as $product){ ?>
                        <div class="col-md-12">
                            <article class="article border rounded mb-3">
                                <div class="article-header">
                                    <div class="article-image" style="background-image: url('<?=$product['image']!=""?base_url("assets/uploads/product-image/".$product['image']):''?>');">
                                    </div>
                                    <div class="article-title">
                                    <h2><a href="<?=$product['url']!=""?htmlspecialchars($product['url']):'#'?>" target="_blank"><?=htmlspecialchars($product['title'])?></a></h2>
                                    </div>
                                </div>
                                <div class="article-details">
                                    <p><?=htmlspecialchars($product['description'])?></p>
                                    <div class="article-cta">
                                    <a href="<?=$product['url']!=""?htmlspecialchars($product['url']):'#'?>" target="_blank" class="btn btn-primary"><?=$this->lang->line('view')?htmlspecialchars($this->lang->line('view')):'View'?></a>
                                    </div>
                                </div>
                            </article>
                        </div>
                    <?php } ?>
                </div>
            </div>
		</div>
        <?php } ?>

        
        <?php if(($card['id'] == 1 || ($this->data['card_plan_modules'] && $this->data['card_plan_modules']['gallery'])) && isset($gallery) && $gallery != ''){ ?>
            <div class="row d-flex justify-content-center">
                <div class="col-md-5 m-0 mt-1 p-0">
                    <div class="card p-2 m-0">
                        <div class="card-header d-flex justify-content-center p-0">
                            <h4><?=$this->lang->line('gallery')?htmlspecialchars($this->lang->line('gallery')):'Gallery'?></h4>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="gallery gallery-md text-center">
                            <?php foreach($gallery as $gal){ if($gal['content_type'] == 'upload'){ ?>

                            <a href="<?=$gal['url']!=""?base_url("assets/uploads/product-image/".$gal['url']):''?>" data-toggle="lightbox"><div class="gallery-item" data-image="<?=$gal['url']!=""?base_url("assets/uploads/product-image/".$gal['url']):base_url("assets/img/video-thumbnail.png")?>"></div></a>

                            <?php }else{ ?>

                            <a href="<?=$gal['url']!=""?$gal['url']:''?>" data-toggle="lightbox"><div class="gallery-item" data-image="<?=$gal['content_type']=='custom' && $gal['url']!=""?$gal['url']:base_url("assets/img/video-thumbnail.png")?>"></div></a>

                            <?php } } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php if(($card['id'] == 1 || ($this->data['card_plan_modules'] && $this->data['card_plan_modules']['testimonials'])) && isset($testimonials) && $testimonials != ''){ ?>
        <div class="row d-flex justify-content-center">
			<div class="col-md-5 p-0">
                <div class="card m-0 mt-1">
                    <div class="card-header d-flex justify-content-center p-0">
                        <h4><?=$this->lang->line('testimonials')?htmlspecialchars($this->lang->line('testimonials')):'Testimonials'?></h4>
                    </div>
                    <div class="col-md-12">
                        <div class="owl-carousel owl-theme" id="products-carousel">
                            <?php foreach($testimonials as $product){ ?>
                            <div>
                                <div class="product-item pb-3">
                                    <div class="product-image">
                                    <img alt="image" src="<?=$product['image']!=""?base_url("assets/uploads/product-image/".$product['image']):base_url('assets/uploads/logos/'.half_logo())?>" class="img-fluid">
                                    </div>
                                    <div class="product-details">
                                    <div class="product-name"><?=htmlspecialchars($product['title'])?></div>
                                    <div class="product-review">
                                            <i class="<?=$product['rating']>=1?'fas':'far'?> fa-star"></i>
                                            <i class="<?=$product['rating']>=2?'fas':'far'?> fa-star"></i>
                                            <i class="<?=$product['rating']>=3?'fas':'far'?> fa-star"></i>
                                            <i class="<?=$product['rating']>=4?'fas':'far'?> fa-star"></i>
                                            <i class="<?=$product['rating']>=5?'fas':'far'?> fa-star"></i>
                                    </div>
                                    <div class="text-muted text-small"><?=htmlspecialchars($product['description'])?></div>
                                    </div>  
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
		</div>
        <?php } ?>
        
        <?php if($card['id'] == 1 || ($this->data['card_plan_modules'] && $this->data['card_plan_modules']['qr_code'])){ ?>
        <div class="row d-flex justify-content-center">
			<div class="col-md-5 p-0">
                <div class="card text-center m-0 mt-1">
                    <div class="card-header d-flex justify-content-center p-0">
                        <h4><?=$this->lang->line('my_qr_code')?htmlspecialchars($this->lang->line('my_qr_code')):'My QR Code'?></h4>
                    </div>
                    <div class="col-md-12" id="code">
                        
                    </div>
                    <div class="col-md-12 my-3">
                        <button onclick="xiazai()" class="btn btn-icon icon-left btn-outline-dark"><?=$this->lang->line('download_my_qr_code')?htmlspecialchars($this->lang->line('download_my_qr_code')):'Download My QR Code'?></button>
                    </div>
                </div>
            </div>
		</div>
        <?php } ?>


        <?php if(($card['id'] == 1 || ($this->data['card_plan_modules'] && $this->data['card_plan_modules']['enquiry_form'])) && isset($social_options['mandatory']) && isset($social_options['mandatory']['email']) && $social_options['mandatory']['email'] != ''){ ?>
            <div class="row d-flex justify-content-center">
                <div class="col-md-5 m-0 mt-1 p-0">
                    <form action="<?=base_url('cards/send_mail')?>" method="POST" id="enquiryform" enctype="multipart/form-data">
                        <input type="hidden" name="user_email" value="<?=htmlspecialchars($social_options['mandatory']['email'])?>">
                        <div class="card p-2 m-0">
                            <div class="card-header text-center d-flex justify-content-center p-0">
                                <h4><?=$this->lang->line('enquiry_form')?htmlspecialchars($this->lang->line('enquiry_form')):'Enquiry Form'?></h4>
                            </div>
                            <div class="row p-3">
                                <div class="form-group col-md-12">
                                    <input type="text" name="name" placeholder="<?=$this->lang->line('name')?htmlspecialchars($this->lang->line('name')):'Name'?>" class="form-control" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="text" name="email" placeholder="<?=$this->lang->line('email')?htmlspecialchars($this->lang->line('email')):'Email'?>" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="text" name="mobile" placeholder="<?=$this->lang->line('mobile')?htmlspecialchars($this->lang->line('mobile')):'Mobile'?>" class="form-control">
                                </div>
                                <div class="form-group col-md-12">
                                    <textarea type="text" name="msg" placeholder="<?=$this->lang->line('type_your_message')?htmlspecialchars($this->lang->line('type_your_message')):'Type your message'?>" class="form-control" required></textarea>
                                </div>

                                <div class="card-footer">
                                    <button class="btn btn-primary savebtn"><?=$this->lang->line('send')?htmlspecialchars($this->lang->line('send')):'Send'?></button>
                                </div>
                                <div class="result"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>         
        <?php } ?>

	</div>

<?php $this->load->view('cards/foot'); ?>
<body>
</html>