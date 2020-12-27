<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    body {
        background-color: #000;
        color: #ffffff;
        font-family: sans-serif;
    }

    .category {
        display: flex;
        flex-direction: column;
        padding: 1em;
    }

    .category-title {
        background-color: rgba(255, 255, 255, 0.5);
        padding: 0.3em 1em;
        margin-bottom: 1em;
    }

    .category-games {
        display: flex;
        flex-wrap: wrap;
    }

    .category-game {
        flex: 0 1 50%;
        padding: 2em;
        max-width: 320px;
    }

    .game-img {
        width: 100%;
        height: 150px;
    }
    .game-text h3 {
        font-size: 1.4;
        font-weight: 400;
        color: skyblue;
    }
    .game-text a {
        background-color: skyblue;
        display: table;
        padding: 0.3em 1em;
        color: #000;
        text-decoration: none;
        margin-top: 1em;
        font-size: 0.9em;
    }
</style>

<?php foreach ($categories as $category): ?>
    
    <div class="category">
        <div class="category-title">Category - <strong><?=$category['category_name']?></strong></div>
        
        <div class="category-games">
            <?php if (isset($category['games']) && !empty($category['games'])): foreach ($category['games'] as $game): ?>
            <div class="category-game">
                <img src="<?=$game['game_picture']?>" alt="<?=$game['game_title']?>" class="game-img">
                <div class="game-text">
                    <h3><?=$game['game_title']?></h3>
                    <h6>Created by <?=$game['game_author']?> - <?=normal_date($game['game_created'])?></h6>

                    <?php if (isset($game['rounds']) && !empty($game['rounds']) && isset($game['rounds'][0]['textblocks']) && !empty($game['rounds'][0]['textblocks'])): ?>

                        <?=str_split($game['rounds'][0]['textblocks'][0]['tb_text'], TEXT_CHARACTERS_GAME_THUMBNAIL)[0]?>

                    <?php endif; ?>

                    <a href="<?=URL?>/front/play.php?game=<?=$game['game_id']?>">play now</a>
                </div>
            </div>
            <?php endforeach; endif; ?>
        </div>
    </div>

<?php endforeach; ?>

