<?php
/**
* Шаблон для формы логина
*/
?>

<div class="col-lg-4 col-lg-offset-4">
	<h1>Пожалуйста войдите</h1>
	<?php $fattr = array('class' => 'form-signin');
		echo form_open(base_url().'index.php/user/login/', $fattr); ?>
	<div class="form-group">
		<?php echo form_input(array(
			'name'=>'email',
			'id'=>'email',
			'placeholder'=>'Email',
			'class'=>'form-control',
			'value'=>set_value('email')
		)); ?>
		<?php echo form_error('email') ?>
	</div>
	<div class="form-group">
		<?php echo form_password(array(
			'name'=>'password',
			'id'=>'password',
			'placeholder'=>'Пароль',
			'class'=>'form-control',
			'value'=>set_value('password')
		)); ?>
		<?php echo form_error('password') ?>
	</div>
	<?php echo form_submit(array('value'=>'Войти!', 'class'=>'btn btn-lg btn-primary btn-block')); ?>
	<?php echo form_close(); ?>
	<p>Нажмите для <a href="<?php echo base_url();?>index.php/user/register">регистрации</a>.</p>
</div>