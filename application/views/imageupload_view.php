<html>
    <head>
        <title>Upload Form</title>
    </head>
    <body>
        <?php echo form_open_multipart('imageupload/doupload');?>
            <input name="userfile[]" id="userfile" type="file" multiple="" />
            <input type="submit" value="upload" />
        <?php echo form_close() ?>
    </body>
</html>