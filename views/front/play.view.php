<div class="game-play">
    <div class="game-play-inner">

        <div class="game-play-content">
            
            <div class="game-play-image">
                <img src="<?=$game['game_picture']?>" alt="<?=$game['game_title']?>">
            </div>
    
            <?php if ($zero_round): ?>
            <div class="game-play-header">
                <div class="game-text">
                    <h3><?=$game['game_title']?></h3>
                    <h6>Created by <?=$game['game_author']?> - <?=normal_date($game['game_created'])?></h6>
                </div>
                <?php if (isset($game['game_audio']) && !empty($game['game_audio'])): ?>
                <div class="game-sound">
                    <audio controls>
                        <source src="<?=$game['game_audio']?>">
                    </audio>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
    
            <div class="game-text-content">
                <?php foreach ($textblocks as $textblock): ?>
                    <p><?=$textblock['tb_text']?></p>
                <?php endforeach; ?>
            </div>
            
            <form action="" method="post">
                <div class="game-answer-content">
                    <?php foreach ($answerblocks as $answerblock): ?>
                        <div class="game-answer-radio">
                            <input type="radio" name="answer" id="ans-<?=$answerblock['ab_id']?>" value="<?=$answerblock['ab_id']?>"> 
                            <label for="ans-<?=$answerblock['ab_id']?>"><?=$answerblock['ab_text']?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="game-answer-submit">
                    <button type="submit"><?=$last_round ? 'end' : 'next'?></button>
                </div>
            </form>

        </div>

    </div>
</div>

