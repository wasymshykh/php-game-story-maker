<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Story Maker</title>


    <style>

      #rounds {
        display: flex;
        flex-direction: column;
      }
      .round-box {
        border: 1px solid #e0e0e0;
        margin-bottom: 1em;
        padding: 1em;
        margin-left: 1em;
      }

      .round-questions,
      .round-answers {
        position: relative;
        padding: 0.5em 1em;
        background-color: #f3f3f3;
        margin-bottom: 0.5em;
      }

      .add-more-button {
        margin-bottom: 1em;
        text-align: center;
      }
      .add-more-rounds,
      .add-more-button button {
        padding: 0.3em 1em;
        background-color: #c30000;
        border: none;
        border-radius: 2px;
        font-size: 0.9em;
        font-family: inherit;
        color: #f3f3f3;
        cursor: pointer;
      }

      .add-more-rounds {
        background-color: #777777;
      }

      .round-question {
        display: flex;
        flex-direction: column;
        margin-bottom: 0.5em;
        padding-bottom: 0.5em;
        border-bottom: 1px solid #e0e0e0;
      }

      .round-answer-conditions,
      .round-question-conditions {
        display: flex;
      }

      .round-question-conditions select,
      .round-question-footer select,
      .round-answer-conditions select,
      .round-answer-footer select {
        font-family: inherit;
        font-size: 0.9em;
        padding: 0.2em 1em;
        margin: 0.2em;
        border: 1px solid #777777;
      }

      .round-answer-conditions select,
      .round-question-conditions select {
        flex: 1;
      }
      .round-question-conditions .select-conditions,
      .round-answer-conditions .select-conditions {
        flex: 2;
      }

      .round-answer-text,
      .round-question-text {
        display: flex;
        flex-direction: column;
      }
      .round-question-text textarea,
      .round-answer-text textarea {
        flex: 1;
        margin: 0.2em;
        padding: 0.8em 1em;
      }

      .round-question-footer {
        display: flex;
        justify-content: flex-end;
        align-items: center;
      }

      .condition-box {
        font-size:0.8em;
        display: flex;
        align-items: center; 
        margin-top: 0.5em; 
        border-bottom: 1px solid #e0e0e0; 
        padding-bottom: 0.7em
      }

      .round-answer-footer {
        text-align: right;
      }

      .round-button {
        margin-top: 1em;
        text-align: center;
      }

      .page-submit {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 1em 0;
      }

      .page-submit input {
        font-family: inherit;
        font-size: 0.9em;
        font-weight: 700;
        padding: 0.4em 1em;
        background-color: #15B097;
        color: #f3f3f3;
        border: none;
        border-radius: 3px;
        cursor: pointer;
      }

      .alert-box {
        position: fixed;
        right: 10%;
        bottom: 3%;
        padding: 0.5em 1em;
        opacity: 0;
        pointer-events: none;
        transition: 0.3s all;
      }

      .alert-box.show {
        opacity: 1;
        bottom: 5%;
      }

      .alert-box.success {
        background-color: #15B097;
        color: #f3f3f3;
      }.alert-box.error {
        background-color: #c30000;
        color: #f3f3f3;
      }
      

    </style>

    <script
  src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
  crossorigin="anonymous"></script>

</head>
<body>
    