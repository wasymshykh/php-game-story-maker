
<div style="width: 100%; max-width: 700px; display: flex;">

    <div style="flex: 1; border-right: 1px solid #e0e0e0">
        <h5>Conditions</h5>
        <form method="POST" action="">
            
            <?php foreach ($conditions as $condition): ?>
                <div style="font-size:0.8em;display: flex; align-items: center; margin-top: 0.5em; border-bottom: 1px solid #e0e0e0; padding-bottom: 0.7em">
                    <label for="condition-<?=$condition['condition_id']?>"><?=$condition['condition_name']?></label>
                    <input type="text" name="condition[<?=$condition['condition_id']?>]" id="condition-<?=$condition['condition_id']?>" value="<?=$sorted_conditions[$condition['condition_id']] ?? ''?>">
                </div>
            <?php endforeach; ?>


            <button type="submit">Save</button>
        </form>
    </div>

    <div style="flex: 2">

        <form action="" method="post">

            <input type="hidden" name="game_id" value="<?=$game['game_id']?>">

            <div>
                <label for="title">Story Title</label>
                <input type="text" name="title" id="title" value="<?=$_POST['title'] ?? $game['game_title']?>">
            </div>
            <div>
                <label for="category">Story Category</label>
                <select name="category" id="category">
                    <?php foreach ($categories as $category): ?>
                    <option value="<?=$category['category_id']?>" <?=$category['category_id'] != $game['game_category_id'] ? 'selected' : '' ?>><?=$category['category_name']?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label>Story Picture</label>
                <label for="picture">URL</label>
                <input type="text" name="picture" id="picture" value="<?=$_POST['picture'] ?? $game['game_picture']?>">
            </div>
            <div>
                <label>Prolog Audiofile</label>
                <label for="audio">URL</label>
                <input type="text" name="audio" id="audio" value="<?=$_POST['audio'] ?? $game['game_audio']?>">
            </div>


            <div id="rounds">

            <?php foreach ($rounds as $round): ?>
                <div class="round-box" data-round="<?=$round['round_number']?>">
                    <div class="round-questions">
                        <div class="round-question">
                            <div class="round-question-conditions">
                                <select name="conditions_1[<?=$round['round_id']?>][]">
                                    <option value="">no condition *</option>
                                    <?php foreach ($conditions as $c): ?>
                                    <option value="<?=$c['condition_id']?>"><?=$c['condition_name']?></option>
                                    <?php endforeach; ?>
                                </select>

                                <select name="condition_between[<?=$round['round_id']?>][]">
                                    <option value="A">and ></option>
                                    <option value="O">or ></option>
                                </select>

                                <select name="conditions_2[<?=$round['round_id']?>][]">
                                    <option value="">-- *</option>
                                    <?php foreach ($conditions as $c): ?>
                                    <option value="<?=$c['condition_id']?>"><?=$c['condition_name']?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="round-question-text">
                                <textarea name="text[<?=$round['round_id']?>][]" rows="4"></textarea>
                            </div>
                            
                            <div class="round-question-footer">
                                <label>and automatic set</label>
                                <select name="autoset[<?=$round['round_id']?>][]">
                                    <option value="">-- *</option>
                                    <?php foreach ($conditions as $c): ?>
                                    <option value="<?=$c['condition_id']?>"><?=$c['condition_name']?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- add more questions -->
                    <div class="">
                        <button type="button" class="add-more-questions">Add more text</button>
                    </div>
                    <!-- add more questions end -->

                    <div class="round-answers">
                        <div class="round-answer">
                            <div class="round-answer-conditions">
                                <select name="aconditions_1[0][]">
                                    <option value="">no condition *</option>
                                    <?php foreach ($conditions as $c): ?>
                                    <option value="<?=$c['condition_id']?>"><?=$c['condition_name']?></option>
                                    <?php endforeach; ?>
                                </select>

                                <select name="acondition_between[0][]">
                                    <option value="A">and ></option>
                                    <option value="O">or ></option>
                                </select>

                                <select name="aconditions_2[0][]">
                                    <option value="">-- *</option>
                                    <?php foreach ($conditions as $c): ?>
                                    <option value="<?=$c['condition_id']?>"><?=$c['condition_name']?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="round-answer-text">
                                <label>then show this answer option</label>
                                <textarea name="atext[0][]" rows="4"></textarea>
                            </div>
                            
                            <div class="round-answer-footer">
                                <label>when user choose it then automatic set </label>
                                <select name="aautoset[0][]">
                                    <option value="">-- *</option>
                                    <?php foreach ($conditions as $c): ?>
                                    <option value="<?=$c['condition_id']?>"><?=$c['condition_name']?></option>
                                    <?php endforeach; ?>
                                </select>
                                <br>
                                <label>when user choose it then unset </label>
                                <select name="aautoset[0][]">
                                    <option value="">-- *</option>
                                    <?php foreach ($conditions as $c): ?>
                                    <option value="<?=$c['condition_id']?>"><?=$c['condition_name']?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- add more questions -->
                    <div class="">
                        <button type="button" class="add-more-answers">Add more answer block</button>
                    </div>
                    <!-- add more questions end -->
                </div>
            <?php endforeach; ?>

            </div>

            
            <input type="submit" value="save">

        </form>

    </div>

</div>


<script>
    
    $('.add-more-questions').on('click', (e) => {
        let questions_block = $(e.target).parent().parent().find('.round-questions');
        let question_block = $(e.target).parent().parent().find('.round-question');
        if (questions_block.children().length < 3) {
            let round_question = document.createElement('div');
            round_question.classList.add('.round-question');
            round_question.innerHTML = question_block.html();
            questions_block.append(round_question);
        }
    });

    
    $('.add-more-answers').on('click', (e) => {
        let answers_block = $(e.target).parent().parent().find('.round-answers');
        let answer_block = $(e.target).parent().parent().find('.round-answer');
        if (answers_block.children().length < 3) {
            let round_answer = document.createElement('div');
            round_answer.classList.add('.round-answer');
            round_answer.innerHTML = answer_block.html();
            answers_block.append(round_answer);
        }
    });

</script>
