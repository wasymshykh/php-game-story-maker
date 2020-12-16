<?php if ($error): ?>
    <p style="color: red"><?=$error?></p>
<?php endif; ?>

<a href="<?=URL?>/control/add_game.php">add game</a>

<table border="1" style="border-collapse: collapse;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Category</th>
            <th>Title</th>
            <th>Date</th>
            <th>Author</th>
            <th>Play End 1</th>
            <th>Play End 2</th>
            <th>Play End 3</th>
            <th>Play End 4</th>
            <th>Play End 5</th>
            <th>Active</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($games as $game): ?>
        <tr>
            <td><?=$game['game_id']?></td>
            <td><?=$game['category_name']?></td>
            <td><?=$game['game_title']?></td>
            <td><?=$game['game_created']?></td>
            <td><?=$game['game_author']?></td>

            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>

            <td>
                <a href="<?=URL?>/control/edit_game?id=<?=$game['game_id']?>">edit</a>
                
                <button class="delete_game" value="<?=$game['game_id']?>">delete</button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div>
    <hr>
    <table border="1" style="border-collapse: collapse;">
        <thead>
            <th>Categories</th>
            <th></th>
        </thead>
        <tbody id="rows">
            <?php foreach ($categories as $category): ?>
            <tr>
                <td><?=$category['category_name']?></td>
                <td><button class="delete-category" value="<?=$category['category_id']?>">Delete</button></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <form method="POST" action="">
        <hr>
        <h4>Add new</h4>
        <input type="text" name="category_name">
        <button type="submit">add</button>
        <input type="hidden" name="category_create">
    </form>
</div>


<script>
    
    $('.delete-category').on('click', (e) => {

        let category_id = e.target.value;
        let category_row = $(e.target).parent().parent();

        $.ajax('<?=URL?>/control/api/category_api.php?delete='+category_id, {
            'success': (e) => {
                category_row.remove()
            },
            'error': (e) => {
                console.log('no');
            }
        });

    })

</script>


