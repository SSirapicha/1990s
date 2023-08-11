<!-- Series tab from vertical navigation bar -->
<div id="seriesNav" class="navContent" style="display:none;">
    <h1 style="font-size:25px; margin-top:30px;">Series</h1>
    <button class="seriesNavBtn" onclick="seriesContent('seriesList');">List</button> |
    <button class="seriesNavBtn" onclick="seriesContent('seriesNew')">New</button>
</div>

<!-- Series: 'List' button -->
<div id="seriesList" class="seriesContent" style="display:none;">
    <div id="seriesDisplay" class="seriesDisplay" style="padding-top:8px;">
        <?php
            $query = "SELECT * FROM series WHERE userId=". $_SESSION['userId'];
            $result = mysqli_query($conn, $query);
        
            while ($series = mysqli_fetch_assoc($result)) {
        ?>
                <!-- Display series container with poster image from database -->
                <div class="seriesContainer">
                    <div style="background-color:black; border-radius:12px;">
                        <img width="125" height="176" src="./seriesTab/seriesImg/<?php echo $series['poster']; ?>" class="seriesPoster">
                        <!-- Display title and year released of series when hover over series container -->
                        <div class="middle">
                            <div class="seriesDescription">
                                <?php echo $series['title']; ?><br>
                                (<?php echo $series['yearReleased']; ?>)
                            </div>

                            <!-- Expand button at the bottom right to display more info in popup -->
                            <a class="material-symbols-outlined" 
                                style="cursor:pointer; font-size:18px; color:white; position:absolute; right:0; bottom:0;" 
                                onclick="document.getElementById('series<?php echo $series['id']; ?>').style.display='block';">expand_content
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Display series details in popup -->
                <div id="series<?php echo $series['id']; ?>" class="seriesPopup" style="display:none;">
                    <div class="seriesPopupContainer">
                        <!-- 'X' : to close popup -->
                        <div class="seriesPopupHeader">
                            <span style="float:right; font-size:25px; cursor:pointer;" 
                                    onclick="document.getElementById('series<?php echo $series['id']; ?>').style.display='none'">&times;
                            </span>
                        </div>

                        <!-- Series details -->
                        <div class="seriesPopupContent">
                            <div style="float:left;">
                                <img width="160" height="211" src="./seriesTab/seriesImg/<?php echo $series['poster']; ?>" class="seriesPoster">
                            </div>
                
                            <div style="float:left; padding-top:10px; padding-bottom:20px; padding-left:20px;">
                                <div style="width:190px;"><?php echo $series['title']; ?></div><br>
                                Year: <?php echo $series['yearReleased']; ?><br>
                                Country: <?php echo $series['country']; ?><br>
                                Type: <?php echo $series['type']; ?>

                                <?php
                                    // If there's a notes, display notes
                                    $notes = $series['notes'];
                                    if ($notes != null) {
                                        echo '<br><br>&#128221:<br>';
                                        echo '<div style="width:190px;">';
                                        echo $notes;
                                        echo '</div>';
                                    }
                                ?>
                            </div>
                        </div>
                        <br>
                        
                        <!-- Delete button : display popup to confirm deletion -->
                        <button style="float:right; position:absolute; right:0; bottom:0; margin-right:60px; margin-bottom:18px;"
                                onclick="document.getElementById('deleteSeriesConfirm<?php echo $series['id']; ?>').style.display='block'">Delete
                        </button>

                        <!-- Edit button : display popup for editing series -->
                        <button style="float:right; position:absolute; right:0; bottom:0; margin-right:20px; margin-bottom:18px;" 
                                onclick="document.getElementById('series<?php echo $series['id']; ?>').style.display='none',
                                            document.getElementById('seriesEdit<?php echo $series['id']; ?>').style.display='block'">Edit
                        </button>
                    </div>
                </div>

                <!-- Display popup to confirm deletion -->
                <div id="deleteSeriesConfirm<?php echo $series['id']; ?>" class="deleteSeriesConfirm" style="display:none">
                    <div class="deleteSeriesConfirmPrompt">
                        <p style="float:left; color:white; font-size:15px; padding-left:9px;">Are you sure you want to delete?</p>

                        <!-- No button : cancel deletion -->
                        <button style="float:right; margin-top:14px;"
                                onclick="document.getElementById('deleteSeriesConfirm<?php echo $series['id']; ?>').style.display='none'">No
                        </button>

                        <button id="deleteSeriesId<?php echo $series['id']; ?>" name="deleteSeriesId" style="float:right; margin-top:14px; margin-right:3px;" 
                                onclick="deleteSeries(<?php echo $series['id']; ?>)">Yes
                        </button>
                    </div>
                </div>

                <!-- Display popup to edit series -->
                <div id="seriesEdit<?php echo $series['id']; ?>" class="seriesPopup" style="display:none;">
                    <div class="seriesPopupContainer">
                        <div class="seriesPopupHeader">
                            <!-- 'X' : to close popup -->
                            <span style="float:right; font-size:25px; cursor:pointer;" 
                                    onclick="document.getElementById('seriesEdit<?php echo $series['id']; ?>').style.display='none'">&times;
                            </span>
                        </div>
                        
                        <!-- Display current details on popup to edit -->
                        <div class="seriesPopupContent">
                            <div style="float:left;">
                                <img width="160" height="211" src="./seriesTab/seriesImg/<?php echo $series['poster']; ?>" class="seriesPoster">
                            </div>
                            
                            <div style="float:left; padding-top:10px; padding-bottom:20px; padding-left:20px;">
                                <input type="text" class="editSeriesTitle" id="editTitle<?php echo $series['id']; ?>" name="editTitle" value="<?php echo $series['title']; ?>">
                                <br><br>

                                Year:
                                <input type="number" class="editSeriesYear" id="editYearReleased<?php echo $series['id']; ?>" name="editYearReleased" value="<?php echo $series['yearReleased']; ?>" 
                                        onKeyPress="if (this.value.length==4) return false;">
                                <br>

                                Country:
                                <select class="editSeriesDropdown" id="editCountry<?php echo $series['id']; ?>" name="editCountry">
                                    <option value="<?php echo $series['country']; ?>" selected><?php echo $series['country']; ?></option>
                                    <option value="China">China</option>
                                    <option value="Japan">Japan</option>
                                    <option value="South Korea">South Korea</option>
                                    <option value="Sweden">Sweden</option>
                                    <option value="Thailand">Thailand</option>
                                    <option value="USA">USA</option>
                                </select>
                                <br>

                                Type:
                                <select class="editSeriesDropdown" id="editType<?php echo $series['id']; ?>" name="editType">
                                    <option value="<?php echo $series['type']; ?>" selected><?php echo $series['type']; ?></option>
                                    <option value="Drama">Drama</option>
                                    <option value="Film">Film</option>
                                    <option value="Movie">Movie</option>
                                    <option value="Series">Series</option>
                                    <option value="TV Show">TV Show</option>
                                </select>
                                <br>

                                <?php
                                    $notes = $series['notes'];
                                    echo '<br>&#128221:<br>';
                                    if ($notes != null) { ?>
                                        <!-- If there's notes, display notes -->
                                        <textarea class="editSeriesNotes" id="editNotes<?php echo $series['id']; ?>" name="editNotes" spellcheck="false" maxlength="100"><?php echo $series['notes']; ?></textarea>
                                <?php } else { ?>
                                        <!-- If there's no notes, display 'Write something here...'-->
                                        <textarea class="editSeriesNotes" id="editNotes<?php echo $series['id']; ?>" name="editNotes" placeholder="Write something here..." spellcheck="false" maxlength="100"></textarea>
                                <?php } ?>
                                <br>

                                <button id="editSeriesId<?php echo $series['id']; ?>" name="editSeriesId" style="float:right; position:absolute; right:0; bottom:0; margin-right:20px; margin-bottom:18px;"
                                        onclick="editSeries(<?php echo $series['id']; ?>)">Save
                                </button>

                                <button style="float:right; position:absolute; right:0; bottom:0; margin-right:60px; margin-bottom:18px;"
                                        onclick="document.getElementById('series<?php echo $series['id']; ?>').style.display='block'
                                                    document.getElementById('seriesEdit<?php echo $series['id']; ?>').style.display='none'">Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
        <?php 
            } 
        ?>
    </div> 
</div>

<!-- Series: 'New' button -->
<div id="seriesNew" class="seriesContent" style="display:none;">
    <form id="newSeriesForm" class="newSeries" action="./seriesTab/newSeries.php" enctype="multipart/form-data">
        <!-- Upload series poster image -->
        <div class="posterContainer">
            <span class="drop-zone__prompt" style="background-color:inherit;">Click to Upload</span>
            <input type="file" accept="image/*" name="posterImage" class="drop-zone__input" required>
        </div>

        <!-- Enter title of the series -->
        <div class="newSeriesForm">
            <label class="newSeriesLabel" for="title">Title<span style="color:red;">*</span></label>
            <input type="text" class="newSeriesInput" name="title" placeholder="Title" required>
        </div>

        <!-- Enter year released of the series -->
        <div class="newSeriesForm">
            <label class="newSeriesLabel" for="year">Year Released<span style="color:red;">*</span></label>
            <input type="number" class="newSeriesInput" name="yearReleased" placeholder="Format: YYYY" onKeyPress="if (this.value.length==4) return false;" required>
        </div>

        <!-- Enter country of the series -->
        <div class="newSeriesForm">
            <label class="newSeriesLabel" for="country">Country<span style="color:red;">*</span></label>
            <select class="newSeriesDropdown" name="country" required>
                <option> </option>
                <option value="China">China</option>
                <option value="Japan">Japan</option>
                <option value="South Korea">South Korea</option>
                <option value="Sweden">Sweden</option>
                <option value="Thailand">Thailand</option>
                <option value="USA">USA</option>
            </select>
        </div>

        <!-- Enter type of the series -->
        <div class="newSeriesForm">
            <label class="newSeriesLabel" for="type">Type<span style="color:red;">*</span></label>
            <select class="newSeriesDropdown" name="type" required>
                <option> </option>
                <option value="Drama">Drama</option>
                <option value="Film">Film</option>
                <option value="Movie">Movie</option>
                <option value="Series">Series</option>
                <option value="TV Show">TV Show</option>
            </select>
        </div>

        <!-- Enter notes for series -->
        <div class="newSeriesForm">
            <label class="newSeriesLabel" for="notes">Notes:</label><br>
            <textarea class="newSeriesTextarea" name="notes" rows="4" placeholder="Write something here..." spellcheck="false" maxlength="100"></textarea>
        </div>

        <input type="reset" name="reset" value="Reset">
        <input type="submit" value="Save">
    </form>
</div>

<script>
    // Update series list after submitting form
    $("#newSeriesForm").on("submit", function(e) {
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
                $("#seriesDisplay").html(data);

                seriesContent('seriesList');
                $('#seriesList').load(' #seriesDisplay');
            },
            error: function() {}
        });
    });

    function deleteSeries(id) {
        // Get id and pass it to php
        $('#seriesDisplay').load('./seriesTab/seriesProcess.php', {type:1, val:id});
    }

    function editSeries(id) {
        var t = $('#editTitle'+id).val(); 
        var y = $('#editYearReleased'+id).val(); 
        var c = $('#editCountry'+id).val(); 
        var p = $('#editType'+id).val(); 
        var n = $('#editNotes'+id).val(); 

        $('#seriesDisplay').load('./seriesTab/seriesProcess.php', {type:2, val:id, editTitle:t, editYearReleased:y, editCountry:c, editNotes:n, editType:p});
    }

    // Drop image on new series form
    document.querySelectorAll(".drop-zone__input").forEach((inputElement) => {
        const dropZoneElement = inputElement.closest(".posterContainer");

        dropZoneElement.addEventListener("click", (e) => {
            inputElement.click();
        });

        inputElement.addEventListener("change", (e) => {
            if (inputElement.files.length) {
                updateThumbnailSeries(dropZoneElement, inputElement.files[0]);
            }
        });

        dropZoneElement.addEventListener("dragover", (e) => {
            e.preventDefault();
            dropZoneElement.classList.add("drop-zone--over");
        });

        ["dragleave", "dragend"].forEach((type) => {
            dropZoneElement.addEventListener(type, (e) => {
                dropZoneElement.classList.remove("drop-zone--over");
            });
        });

        dropZoneElement.addEventListener("drop", (e) => {
            e.preventDefault();

            if (e.dataTransfer.files.length) {
                inputElement.files = e.dataTransfer.files;
                updateThumbnailSeries(dropZoneElement, e.dataTransfer.files[0]);
            }

        dropZoneElement.classList.remove("drop-zone--over");
        });
    });

    // Update thumbnail on new series form
    function updateThumbnailSeries(dropZoneElement, file) {
        let thumbnailElement = dropZoneElement.querySelector(".drop-zone__thumb");

        // First time - remove the prompt
        if (dropZoneElement.querySelector(".drop-zone__prompt")) {
            dropZoneElement.querySelector(".drop-zone__prompt").remove();
        }

        // First time - if there is no thumbnail element, create it
        if (!thumbnailElement) {
            thumbnailElement = document.createElement("div");
            thumbnailElement.classList.add("drop-zone__thumb");
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