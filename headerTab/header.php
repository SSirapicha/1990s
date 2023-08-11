<!-- Header tab from vertical navigation bar -->
<div id="headerNav" class="navContent" style="display:block;">
    <h1 style="font-size:25px; margin-top:30px;">Header</h1>
    Emoji: 
    <input type="text" class="navEmoji" id="navEmoji" name="navEmoji" onchange="emojiUpdate()" value="<?php echo $header['emoji']; ?>" maxlength="20">
    <br><br>

    <!-- Form to upload/update three header images -->
    <div id="headerImgForm">
        <form id="headerImg1Form" action="./headerTab/headerProcess.php" enctype="multipart/form-data">
            <label for="headerImg1">Header 1</label>
            <input type="file" accept="image/*" id="headerImg1" name="headerImg1">
            <input type="submit" onclick="headerImgForm('#headerImg1Form')" value="Save">
        </form>
        <img src="./headerTab/headerImg/<?php echo $header['img1']; ?>" width="300" height="80">

        <form id="headerImg2Form" action="./headerTab/headerProcess.php" enctype="multipart/form-data">
            <label for="headerImg2">Header 2</label>
            <input type="file" accept="image/*" id="headerImg2" name="headerImg2">
            <input type="submit" onclick="headerImgForm('#headerImg2Form')" value="Save">
        </form>
        <img src="./headerTab/headerImg/<?php echo $header['img2']; ?>" width="300" height="80">

        <form id="headerImg3Form" action="./headerTab/headerProcess.php" enctype="multipart/form-data">
            <label for="headerImg3">Header 3</label>
            <input type="file" accept="image/*" id="headerImg3" name="headerImg3">
            <input type="submit" onclick="headerImgForm('#headerImg3Form')" value="Save">
        </form>
        <img src="./headerTab/headerImg/<?php echo $header['img3']; ?>" width="300" height="80">
    </div>
</div>

<script>
    // Update emoji when type
    $('input').keyup(function() {
        var emj = $('#navEmoji').val();
        $('#displayHorNavEmoji').text(emj); 
    });

    // Update status message to db when click outside of input area
    function statusMsgUpdate() {
        var v = $('#statusMsg').val(); 
        $('#statusMsg').load('./headerTab/headerProcess.php', {type:1, val:v});
    }

    // Update emoji to db when click outside of input area
    function emojiUpdate() {
        var v = $('#navEmoji').val(); 
        $('#displayHorNavEmoji').load('./headerTab/headerProcess.php', {type:2, val:v});
    }

    // Update status message to db when press enter
    $('#statusMsg').keydown(function(e) {
        if (e.key === "Enter") {
            statusMsgUpdate();
        }
    })

    // Update emoji to db when press enter
    $('#navEmoji').keydown(function(e) {
        if (e.key === "Enter") {
            emojiUpdate();
        }
    })

    // Update specific header image by passing id ('#headerImg1Form')
    function headerImgForm(id) {
        $(id).on("submit", function(e) {
            e.preventDefault();

            var form = $(this)[0];
            var formData = new FormData(form);
            var actionUrl = $(this).attr("action");

            $.ajax ({
                url: actionUrl,
                data: formData,
                processData: false,
                contentType: false,
                type: 'POST',
                
                success: function(data) {
                    $("#slideContainer").html(data);

                    // Update images on <header> and header tab
                    $('#slideContainer').load(' #slideContainer');
                    $('#headerImgForm').load(' #headerImgForm');
                    displaySlideShow();
                },
                error: function() {}
            });
        });
    }
</script>