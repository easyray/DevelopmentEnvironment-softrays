<!DOCTYPE html>
<html>
<body>

	<h3><?php echo 'Custom dialog'; ?></h3>
	Input some text: <textarea id="content" cols="30" rows="10"></textarea> 
	<input type="hidden" id="content2" />
	<button onclick="top.tinymce.activeEditor.windowManager.getWindows()[0].close();">Close window</button>
</body>
</html>