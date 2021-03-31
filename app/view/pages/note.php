<?php
    require APPROOT . '/view/head/head.php';
    require APPROOT . '/view/head/nav.php';
?>

<main class="container align-self-center ">    
    <section class="row">
        <h1 class="row col-sm-12 align-self-center">Create a note right here!</h1>
        <section class="col-sm note backgroundGreen">
            <form action="<?php echo URLROOT ?>/NoteController/createNoteCon" method="POST">
                <textarea class="noteArea" placeholder="What is on your mind?" contenteditable="true" name="textContent"></textarea>
                <input type="radio" name="colorId" value="0" checked="checked">
                <label for="Green">Green</label>
                <input type="radio" name="colorId" value="1">
                <label for="Yellow">Yellow</label>
                <input type="radio" name="colorId" value="2">
                <label for="Red">Red</label>
                <input type="radio" name="colorId" value="3">
                <label for="Blue">Blue</label>
                <button class="noteSaveBtn" type="submit" value="submit">Save</button>
            </form>
        </section>
    </section>
    <span class="error " ><?php echo $data["errorMess"] ?></span>
    <section class="row">
        <h1 class="row col-sm-12 align-self-center">Here are the notes that you made.</h1>
        <?php
            // check for which background is checked
            foreach ($data['notes'] as $note) {
                switch($note->ColorId) {
                    case 0:
                        echo '<section class="col-sm note backgroundGreen">';
                        break;
                    case 1:
                        echo '<section class="col-sm note backgroundYellow">';
                        break;
                    case 2:
                        echo '<section class="col-sm note backgroundRed">';
                        break;
                    case 3:
                        echo '<section class="col-sm note backgroundBlue">';
                        break;
                }
        ?>
        <form action="<?php echo URLROOT ?>/NoteController/updateNoteCon">
            <input type="hidden" name="action" value="_UPDATE"> 
            <input type="hidden" name="noteId" value="<?php echo $note->NoteId ?>"> 
            <textarea class="noteArea" contenteditable="true" name="textContent"><?php echo $note->TextContent ?></textarea>
            <p class="noteStamp">Created on: <?php echo $note->CreateStamp?></p>
            <?php
                // Check for which color radio button is checked 
                $tempChecked = '';
                if($note->ColorId == 0) {
                    $tempChecked = 'checked="checked"';
                }
                echo '<input type="radio" name="colorId" value="0" ' . $tempChecked . '>';
                echo ' <label for="Green">Green</label>';
                $tempChecked = '';
                if($note->ColorId == 1) {
                    $tempChecked = 'checked="checked"';
                }
                echo '<input type="radio" name="colorId" value="1" ' . $tempChecked . '>';
                echo ' <label for="Yellow">Yellow</label>';
                $tempChecked = '';
                if($note->ColorId == 2) {
                    $tempChecked = 'checked="checked"';
                }
                echo '<input type="radio" name="colorId" value="2" ' . $tempChecked . '>';
                echo ' <label for="Red">Red</label>';
                $tempChecked = '';
                if($note->ColorId == 3) {
                    $tempChecked = 'checked="checked"';
                }
                echo '<input type="radio" name="colorId" value="3" ' . $tempChecked . '>';
                echo ' <label for="Blue">Blue</label>';
            ?>
            <button class="noteSaveBtn" type="submit" value="submit">Save</button>
        </form>
        <form action="<?php echo URLROOT ?>/NoteController/deleteNoteCon">
            <input type="hidden" name="noteId" value="<?php echo $note->NoteId ?>"> 
            <input type="hidden" name="action" value="_DELETE"> 
            
            <button type="submit" value="submit">Delete note</button>
        </form>
        <?php       
            echo '</section>';
            }

        ?> 
    </section>
</main>

<!-- Script for autogrow textarea -->
<script>
    $(function(){
        $('.noteArea').autogrow({vertical: true, horizontal: false});
    });
</script>