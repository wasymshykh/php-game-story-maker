<?php if ($error): ?>
    <p style="color: red"><?=$error?></p>
<?php endif; ?>

<form method="POST" action="" enctype="multipart/form-data">
    <div>
        <label for="title">Story Title</label>
        <input type="text" name="title" id="title" value="<?=$_POST['title'] ?? ''?>">
    </div>
    <div>
        <label for="category">Story Category</label>
        <select name="category" id="category">
            <?php foreach ($categories as $category): ?>
            <option value="<?=$category['category_id']?>"><?=$category['category_name']?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <label for="author">Author Name</label>
        <input type="text" name="author" id="author" value="<?=$_POST['author'] ?? ''?>">
    </div>
    <div>
        <label>Story Picture</label>
        <label for="picture">URL</label>
        <input type="text" name="picture" id="picture" value="<?=$_POST['picture'] ?? ''?>">
        or
        <label for="picture-file">File</label>
        <input type="file" name="picture-file" id="picture-file" accept="image/*">
    </div>
    <div>
        <label>Prolog Audiofile</label>
        <label for="audio">URL</label>
        <input type="text" name="audio" id="audio" value="<?=$_POST['audio'] ?? ''?>">
        or
        <label for="audio-file">File</label>
        <input type="file" name="audio-file" id="audio-file" accept=".mp3,audio/*">
    </div>

    <div>
        <button type="submit">Create</button>
    </div>
</form>

