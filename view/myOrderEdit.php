<?php
class ViewMyOrderEdit {

	public function render($datas)
	{
		$data = $GLOBALS['DATA'];

		include(VIEW.'/header.php');
		include(VIEW.'/banner.php');

		$html = '<div class="container"><div class="row-fluid"><div class="span9"><div class = "span12">';
		if($datas['up'] == 'faild')
		{
			$html .='<div class="alert alert-error fade in"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>修改失败!</strong></div>';
		}
		$id = $datas['order']['_id'];
		$name =$datas['order']['name'];
		if($datas['order']['creattime'])
			$date =date("Y-m-d H:i:s",$datas['order']['creattime']);
		else
			$date =date("Y-m-d H:i:s");
		$phone = $datas['order']['phone'];
		$address = $datas['order']['address'];
		$items = implode(',',$datas['order']['items']);
		$comments = $datas['order']['comments'];
		$dongdamenOrder = implode(',',$datas['order']['ddmOrder']);
		$taobaoOrder = implode(',',$datas['order']['tbOrder']);
		$tbname = $datas['order']['tbname'];
		$html .="
		<div class='well' >
			<form action='/myorder/update' method='post'>
					<input type='hidden' name='id' value='{$id}' />
				<fieldset>
					<legend>订单详情</legend>
					<label>姓名</label>
					<input type='text' name='name' value='{$name}' />
					<label>日期</label>
					<input type='text' name='date' value='{$date}' />
					<label>电话</label>
					<input type='text' name='phone' value='{$phone}' />
					<label>地址</label>
					<textarea rows='4' name='address'>{$address}</textarea>
					<label>货号</label>
					<input class='input-xxlarge' type='text' name='items' value='{$items}' />
					<label>备注</label>
					<textarea rows='4' name='comments' >{$comments}</textarea>
					<label>东大门订单id</label>
					<input class='input-xxlarge' type='text' name='ddmOrder' value='{$dongdamenOrder}' />
					<label>淘宝订单id</label>
					<input class='input-xxlarge' type='text' name='tbOrder' value='{$taobaoOrder}' />
					<label>淘宝昵称</label>
					<input type='text' name='tbname' value='{$tbname}' />
					<label></label>
					<button type='submit' class='btn btn-primary'>Submit</button>
				</fieldset>
			</form>
		</div>
		";

		$html .='</div></div></div>';
		echo $html;
		//include(VIEW.'/container.php');
			
		include(VIEW.'/footer.php');
	}


}
?>
