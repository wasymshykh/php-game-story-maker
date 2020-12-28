<div class="game-play">
    <div class="game-play-inner">
        
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

    </div>
</div>

