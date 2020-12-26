
<div style="width: 100%; max-width: 700px; display: flex;">

<div style="flex: 1; border-right: 1px solid #e0e0e0">
    <h5>Conditions</h5>
    <form method="POST" action="">
        <div class="condition-boxes">
            <?php foreach ($condition_details as $condition_name => $condition): ?>
                <div class="condition-box">
                    <label for="condition-<?=$condition['condition_id']?>"><?=$condition_name?></label>
                    <input type="text" name="condition[<?=$condition['condition_id']?>]" id="condition-<?=$condition['condition_id']?>" value="<?=$condition['condition_value']?>">
                </div>
            <?php endforeach; ?>
        </div>
        <button type="submit">Save</button>
    </form>
</div>

<div style="flex: 2">

    <form action="" method="post" id="page-form">

        <input type="hidden" name="save_game" value="<?=$game['game_id']?>">

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
            <label for="author">Author</label>
            <input type="text" name="author" id="author" value="<?=$_POST['author'] ?? $game['game_author']?>">
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
        <?php foreach ($rounds_details as $round_id => $round_details): ?>
            <div class="round-box" data-round="<?=$round_details['details']['round_number']?>" data-round-id="<?=$round_id?>">
                <div class="round-questions">
                    <?php foreach ($round_details['texts'] as $textblock):?>
                    <div class="round-question">
                        <div class="round-question-conditions">
                            <select name="conditions_1[<?=$round_id?>][]" class="select-conditions">
                                <option value="">no condition *</option>
                                <?php foreach ($condition_details as $n => $c): ?>
                                <option value="<?=$c['condition_id']?>" <?=$textblock['tb_condition_1_id'] === $c['condition_id'] ? 'selected' : ''?>><?=$n?></option>
                                <?php endforeach; ?>
                            </select>

                            <select name="condition_between[<?=$round_id?>][]">
                                <option value="A">and ></option>
                                <option value="O">or ></option>
                            </select>

                            <select name="conditions_2[<?=$round_id?>][]" class="select-conditions">
                                <option value="">-- *</option>
                                <?php foreach ($condition_details as $n => $c): ?>
                                <option value="<?=$c['condition_id']?>" <?=$textblock['tb_condition_2_id'] === $c['condition_id'] ? 'selected' : ''?>><?=$n?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="round-question-text">
                            <textarea name="text[<?=$round_id?>][]" rows="4"><?=$textblock['tb_text']?></textarea>
                        </div>
                        
                        <div class="round-question-footer">
                            <label>and automatic set</label>
                            <select name="autoset[<?=$round_id?>][]" class="select-conditions">
                                <option value="">-- *</option>
                                <?php foreach ($condition_details as $n => $c): ?>
                                <option value="<?=$c['condition_id']?>" <?=$textblock['tb_auto_set'] === $c['condition_id'] ? 'selected' : ''?>><?=$n?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <!-- add more questions -->
                <div class="add-more-button">
                    <button type="button" class="add-more-questions">Add more text</button>
                </div>
                <!-- add more questions end -->

                <div class="round-answers">
                    <?php foreach ($round_details['answers'] as $answerblock):?>
                    <div class="round-answer">
                        <div class="round-answer-conditions">
                            <select name="aconditions_1[<?=$round_id?>][]" class="select-conditions">
                                <option value="">no condition *</option>
                                <?php foreach ($condition_details as $n => $c): ?>
                                <option value="<?=$c['condition_id']?>" <?=$answerblock['ab_condition_1_id'] === $c['condition_id'] ? 'selected' : ''?>><?=$n?></option>
                                <?php endforeach; ?>
                            </select>

                            <select name="acondition_between[<?=$round_id?>][]">
                                <option value="A">and ></option>
                                <option value="O">or ></option>
                            </select>

                            <select name="aconditions_2[<?=$round_id?>][]" class="select-conditions">
                                <option value="">-- *</option>
                                <?php foreach ($condition_details as $n => $c): ?>
                                <option value="<?=$c['condition_id']?>" <?=$answerblock['ab_condition_2_id'] === $c['condition_id'] ? 'selected' : ''?>><?=$n?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="round-answer-text">
                            <label>then show this answer option</label>
                            <textarea name="atext[<?=$round_id?>][]" rows="4"><?=$answerblock['ab_text']?></textarea>
                        </div>
                        
                        <div class="round-answer-footer">
                            <label>when user choose it then automatic set </label>
                            <select name="aautoset[<?=$round_id?>][]" class="select-conditions">
                                <option value="">-- *</option>
                                <?php foreach ($condition_details as $n => $c): ?>
                                <option value="<?=$c['condition_id']?>" <?=$answerblock['ab_auto_set'] === $c['condition_id'] ? 'selected' : ''?>><?=$n?></option>
                                <?php endforeach; ?>
                            </select>
                            <br>
                            <label>when user choose it then unset </label>
                            <select name="aautoset[<?=$round_id?>][]" class="select-conditions">
                                <option value="">-- *</option>
                                <?php foreach ($condition_details as $n => $c): ?>
                                <option value="<?=$c['condition_id']?>" <?=$answerblock['ab_unset'] === $c['condition_id'] ? 'selected' : ''?>><?=$n?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- add more questions -->
                <div class="add-more-button">
                    <button type="button" class="add-more-answers">Add more answer block</button>
                </div>
                <!-- add more questions end -->
                
            </div>
            <?php endforeach; ?>
        </div>

        <div class="round-button">
            <button type="button" class="add-more-rounds" onclick="add_round()">Add more round</button>
        </div>

        <div class="page-submit">
            <input type="submit" value="save" id="save">
        </div>

    </form>

</div>

</div>


<script>


$('#save').on('click', (e) => {

    e.preventDefault(); // avoid to execute the actual submit of the form.

    var form = $('#page-form');
    var url = "<?=URL?>/control/api/game_api.php";

    $.ajax({
        type: "POST",
        url: url,
        data: form.serialize(), // serializes the form's elements.
        success: function(data)
        {
            console.log(data); // show response from the php script.
        }
        });

})
    

function add_events_on_buttons () {

    $('.add-more-questions').on('click', (e) => {
        let questions_block = $(e.target).parent().parent().find('.round-questions');
        let round_id = questions_block.parent().attr('data-round-id');

        if (questions_block.children().length < 10) {
            questions_block.append(get_question_html(round_id));
        }
    });


    $('.add-more-answers').on('click', (e) => {
        let answers_block = $(e.target).parent().parent().find('.round-answers');
        let round_id = answers_block.parent().attr('data-round-id');

        if (answers_block.children().length < 6) {
            answers_block.append(get_answer_html(round_id));

            let round_number = answers_block.parent().attr('data-round');
            let option_name;

            if (round_number === '0') {
                option_name = 'item'+answers_block.children().length
            } else {
                option_name = 'r'+round_number+'a'+answers_block.children().length
            }
            add_to_select_boxes(option_name);
            add_to_condition_boxes(option_name);
        }
    });

}
add_events_on_buttons();

const game_id = <?=$game['game_id']?>;
const conditions_by_name = {<?php foreach($conditions_by_name as $name => $value){echo "'$name': '$value',";}?>};

function add_to_select_boxes (e) {
    let answers = $('.select-conditions');
    answers.each(i => {
        $(answers[i]).append($('<option>', {value:conditions_by_name[e], text:e}));
    });
}

function add_to_condition_boxes(e) {
    let condition_boxes = $('.condition-boxes');
    condition_boxes.append(get_condition_box_html(conditions_by_name[e], e));
}

function get_condition_box_html (id, name) {
    return `<div class="condition-box"><label for="condition-${id}">${name}</label>
            <input type="text" name="condition[${id}]" id="condition-${id}" value=""></div>`;
}

function add_round () {
    let round_number = $('.round-box').length;

    if (round_number < 10) {

        $.ajax('<?=URL?>/control/api/game_api.php?add_round='+game_id+'&round_number='+round_number, {
                'success': (e) => {
                    if (e.code === 200) {
                        let round_id = e.message.round_id;
                        
                        get_round_html(round_number, round_id);
                        
                    }
                },
                'error': (e) => {
                    console.log('no');
                }
            });

    }

}

function get_select_options() {
    
    let s_children = $('.select-conditions').first().children();

    let options_html = "";
    s_children.each(selectbox => {
        if (selectbox != 0) {
            options_html += `<option value="${s_children[selectbox].value}">${s_children[selectbox].text}</option>`;
        }
    });

    return options_html;
}


function get_question_html (round_id) {

    let options_html = get_select_options();

    return `<div class="round-question">
                <div class="round-question-conditions">
                    <select name="conditions_1[${round_id}][]" class="select-conditions">
                        <option value="">no condition *</option>
                        ${options_html}
                    </select>
                    <select name="condition_between[${round_id}][]">
                        <option value="A">and &gt;</option>
                        <option value="O">or &gt;</option>
                    </select>
                    <select name="conditions_2[${round_id}][]" class="select-conditions">
                        <option value="">-- *</option>
                        ${options_html}
                    </select>
                </div>
                <div class="round-question-text">
                    <textarea name="text[${round_id}][]" rows="4"></textarea>
                </div>
                <div class="round-question-footer">
                    <label>and automatic set</label>
                    <select name="autoset[${round_id}][]" class="select-conditions">
                        <option value="">-- *</option>
                        ${options_html}
                    </select>
                </div>
            </div>`;

}

function get_answer_html (round_id) {

    let options_html = get_select_options();

    return `<div class="round-answer">
                <div class="round-answer-conditions">
                    <select name="aconditions_1[${round_id}][]" class="select-conditions">
                        <option value="">no condition *</option>
                        ${options_html}
                    </select>

                    <select name="acondition_between[${round_id}][]">
                        <option value="A">and &gt;</option>
                        <option value="O">or &gt;</option>
                    </select>

                    <select name="aconditions_2[${round_id}][]" class="select-conditions">
                        <option value="">-- *</option>
                        ${options_html}
                    </select>
                </div>
                
                <div class="round-answer-text">
                    <label>then show this answer option</label>
                    <textarea name="atext[${round_id}][]" rows="4"></textarea>
                </div>
                
                <div class="round-answer-footer">
                    <label>when user choose it then automatic set </label>
                    <select name="aautoset[${round_id}][]" class="select-conditions">
                        <option value="">-- *</option>
                        ${options_html}
                    </select>
                    <br>
                    <label>when user choose it then unset </label>
                    <select name="aautoset[${round_id}][]" class="select-conditions">
                        <option value="">-- *</option>
                        ${options_html}
                    </select>
                </div>
            </div>`;

}


function get_round_html (number, round_id) {

    let options_html = get_select_options();
    
    let question_html = `<div class="round-questions"></div>
                    <div class="add-more-button">
                        <button type="button" class="add-more-questions">Add more text</button>
                    </div>`;

    let answer_html = `<div class="round-answers"></div>
                    <div class="add-more-button">
                        <button type="button" class="add-more-answers">Add more answer block</button>
                    </div>`;

    let round_box = `<div class="round-box" data-round="${number}" data-round-id="${round_id}">${question_html} ${answer_html}</div>`;

    $('#rounds').append(round_box);

    add_events_on_buttons();

}

</script>
