<?php
class ViewPhotoNew {

	public function render($datas)
	{
		$data = $GLOBALS['DATA'];

		include(VIEW.'/header.php');
		include(VIEW.'/banner.php');

		$albums = '<select name ="album_id"><option>请选择相册..</option>';
		if(is_array($data['albums']) && !empty($data['albums']))
		{
			foreach($data['albums'] as $album)
			{
				$albums .='<option value="'.$album['_id'].'">'.$album['title'].'</option>';
			}
		}
		$albums .='</select>';

		$html = '<div class="container"><div class="well">';
		$html .= <<<HTML
		<div >
			<legend>上传照片</legend>		
			<label>相册</label>
				$albums
				<label id = 'newAlbum'>
			<button type="submit" name="newalbum_button" id="newalbum_button" class="btn btn-inverse">新建相册</button>
			</label>
		</div>

		<div style='margin-top:20px;'>
    <form id="fileupload" action="/photo/upload/1" method="POST" enctype="multipart/form-data">
        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
        <div class="row fileupload-buttonbar">
            <div class="span7">
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-success fileinput-button">
                    <i class="icon-plus icon-white"></i>
                    <span>Add files...</span>
                    <input type="file" name="files[]" multiple>
                </span>
                <button type="submit" class="btn btn-primary start">
                    <i class="icon-upload icon-white"></i>
                    <span>Start upload</span>
                </button>
                <button type="reset" class="btn btn-warning cancel">
                    <i class="icon-ban-circle icon-white"></i>
                    <span>Cancel upload</span>
                </button>
                <button type="button" class="btn btn-danger delete">
                    <i class="icon-trash icon-white"></i>
                    <span>Delete</span>
                </button>
                <input type="checkbox" class="toggle">
            </div>
            <!-- The global progress information -->
            <div class="span5 fileupload-progress fade">
                <!-- The global progress bar -->
                <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    <div class="bar" style="width:0%;"></div>
                </div>
                <!-- The extended global progress information -->
                <div class="progress-extended">&nbsp;</div>
            </div>
        </div>
        <!-- The loading indicator is shown during file processing -->
        <div class="fileupload-loading"></div>
        <br>
        <!-- The table listing the files available for upload/download -->
        <table role="presentation" class="table table-striped"><tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody></table>
				<input type='hidden' value=0 id='photoNum' name='photoNum' />
    </form>
		</div>
			<button type="submit" name="photo_button" id="photo_button" class="btn btn-inverse">提交</button>
</div>

</div></div>			
HTML;
		echo $html;
			
		include(VIEW.'/footer.php');
	}


}
?>
