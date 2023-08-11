<!-- Music tab from vertical navigation bar -->
<div id="musicNav" class="navContent" style="display:none;">
    <h1 style="font-size:25px; margin-top:30px;">Music</h1>
    <button class="seriesNavBtn" onclick="musicContent('musicList');">All</button>
</div>

<!-- Music: 'All' button -->
<div id="musicList" class="musicContent" style="display:none;">
    <!-- 'class' same as series -->
    <div id="musicDisplay" class="seriesDisplay" style="padding-top:8px;">
        <?php
            $query = "SELECT * FROM music WHERE userId=". $_SESSION['userId'];
            $result = mysqli_query($conn, $query);
        
            while ($music = mysqli_fetch_assoc($result)) {
        ?>
                <audio id="audio<?php echo $music['id']; ?>">
                    <source src="./musicTab/audio/<?php echo $music['audio']; ?>" type="audio/mpeg">
                </audio>

                <div class="musicContainer">
                    <div style="background-color:black; border-radius:12px;">
                        <img width="125" height="125" src="./musicTab/audioImg/<?php echo $music['poster']; ?>" class="musicPoster">
                        <!-- Display title and artist of songs when hover over container -->
                        <div class="middle">
                            <div class="seriesDescription">
                                <button id="playPauseBtn<?php echo $music['id']; ?>" onclick="
                                    var audio = document.getElementById('audio<?php echo $music['id']; ?>');
                                    var currSongBar = document.getElementById('displayCurrSong');

                                    if (audio.paused) { 
                                        audio.play(); 
                                        // Display what song is currently playing in horizontal navigation bar -->
                                        currSongBar.innerHTML = '♫ <?php echo $music['artist']; ?> - <?php echo $music['title']; ?> ♫';
                                        playPauseBtn<?php echo $music['id']; ?>.innerHTML = 'pause';
                                    }
                                    else { 
                                        audio.pause(); 
                                        currSongBar.innerHTML = '--';
                                        playPauseBtn<?php echo $music['id']; ?>.innerHTML = 'play';
                                    };"
                                >play
                                </button><br>
                                <?php echo $music['title']; ?><br>
                                (<?php echo $music['artist']; ?>)
                            </div>
                        </div>
                    </div>
                </div>
        <?php
            }
        ?>   
        <!-- Open popup to add new song -->
        <button id="openNewMusicFormBtn" class="openNewMusicFormBtn" onclick="document.getElementById('musicNew').style.display = 'block';">
            <span style="color:white; font-size:30px; margin-top:3px; cursor:pointer;" class="material-symbols-outlined">add</span>
        </button> 
    </div>
</div>

<!-- Music: '+' button -->
<div id="musicNew" class="musicNew" class="musicContent" style="display:none;">
    <div class="newMusicForm">
        <!-- Header w/close button -->
        <div style="margin-bottom:10px;">
            <button style="border:none; background-color:inherit; font-size:18px; margin-right:5px; float:right; cursor:pointer" 
                    onclick="document.getElementById('musicNew').style.display = 'none';">X</button>
            <center>New</center>
        </div>

        <form id="newMusicFormId" action="./musicTab/newMusic.php" enctype="multipart/form-data">
            <!-- Upload song poster image -->
            <div class="posterMusicContainer">
                <span class="drop-zone__promptMusic" style="background-color:inherit;">Click to Upload</span>
                <input type="file" accept="image/*" name="posterImage" class="drop-zone__inputMusic" required>
            </div>

            <!-- Enter title of the song -->
            <div class="newSeriesForm">
                <label class="newSeriesLabel" for="title">Title<span style="color:red;">*</span></label>
                <input type="text" class="newMusicInput" name="title" placeholder="Title" required>
            </div>

            <!-- Enter artist of the song -->
            <div class="newSeriesForm">
                <label class="newSeriesLabel" for="artist">Artist<span style="color:red;">*</span></label>
                <input type="text" class="newMusicInput" name="artist" placeholder="Artist" required>
            </div>

            <!-- Upload audio -->
            <div class="newSeriesForm">
                <label class="newSeriesLabel" for="audio">Audio<span style="color:red;">*</span></label>
                <input type="file" accept="audio/*" name="audio" required>
            </div>
            
            <div style="margin-top:17px;">
                <input type="reset" name="reset" value="Reset">
                <input type="submit" value="Save">
            </div>
        </form>
    </div>
</div>

<script>
    // Update music list after submitting form
    $("#newMusicFormId").on("submit", function(e) {
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
                $("#musicDisplay").html(data);

                musicContent('musicList');
                $('#musicList').load(' #musicDisplay');
            },
            error: function() {}
        });
    });

    // Drop image on new music form
    document.querySelectorAll(".drop-zone__inputMusic").forEach((inputElement) => {
        const dropZoneElement = inputElement.closest(".posterMusicContainer");

        dropZoneElement.addEventListener("click", (e) => {
            inputElement.click();
        });

        inputElement.addEventListener("change", (e) => {
            if (inputElement.files.length) {
                updateThumbnailMusic(dropZoneElement, inputElement.files[0]);
            }
        });

        dropZoneElement.addEventListener("dragover", (e) => {
            e.preventDefault();
            dropZoneElement.classList.add("drop-zone--overMusic");
        });

        ["dragleave", "dragend"].forEach((type) => {
            dropZoneElement.addEventListener(type, (e) => {
                dropZoneElement.classList.remove("drop-zone--overMusic");
            });
        });

        dropZoneElement.addEventListener("drop", (e) => {
            e.preventDefault();

            if (e.dataTransfer.files.length) {
                inputElement.files = e.dataTransfer.files;
                updateThumbnailMusic(dropZoneElement, e.dataTransfer.files[0]);
            }

        dropZoneElement.classList.remove("drop-zone--overMusic");
        });
    });

    // Update thumbnail on new music form
    function updateThumbnailMusic(dropZoneElement, file) {
        let thumbnailElement = dropZoneElement.querySelector(".drop-zone__thumbMusic");

        // First time - remove the prompt
        if (dropZoneElement.querySelector(".drop-zone__promptMusic")) {
            dropZoneElement.querySelector(".drop-zone__promptMusic").remove();
        }

        // First time - if there is no thumbnail element, create it
        if (!thumbnailElement) {
            thumbnailElement = document.createElement("div");
            thumbnailElement.classList.add("drop-zone__thumbMusic");
            dropZoneElement.appendChild(thumbnailElement);
        }

        thumbnailElement.dataset.label = file.name;

        // Show thumbnail for image files
        if (file.type.startsWith("image/")) {
            const reader = new FileReader();

            reader.readAsDataURL(file);
            reader.onload = () => {
                thumbnailElement.style.backgroundImage = `url('${reader.result}')`;
            };
        } 
        else {
            thumbnailElement.style.backgroundImage = null;
        }
    }
</script>