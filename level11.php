<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Orrery Level 11 - Quiz</title>
  <style>
    body { margin: 0; overflow: hidden; font-family: Arial, sans-serif; }
    #quiz-container {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: rgba(0, 0, 0, 0.8);
      color: white;
      padding: 20px;
      border-radius: 10px;
      width: 300px;
      text-align: center;
    }
    #question { font-size: 18px; margin-bottom: 15px; }
    .option { margin: 10px 0; padding: 10px; background: #28a745; cursor: pointer; border-radius: 5px; }
    .option:hover { background: #218838; }
    #result { display: none; }
    #next-button {
      margin-top: 15px;
      padding: 10px 20px;
      background: #007bff;
      color: white;
      border: none;
      cursor: pointer;
      font-size: 18px;
      border-radius: 5px;
    }
    #next-button:hover {
      background: #0069d9;
    }
  </style>
</head>
<body>
  <div id="quiz-container">
    <div id="question"></div>
    <div id="options"></div>
    <div id="result"></div>
    <button id="next-button" style="display: none;">Next Question</button>
  </div>

  <script>
    const questions = [
      {
        question: "What is the largest planet in our solar system?",
        options: ["Earth", "Jupiter", "Saturn", "Neptune"],
        answer: 1 // index of the correct answer
      },
      {
        question: "How long does it take Pluto to orbit the Sun?",
        options: ["1 Earth year", "24 Earth years", "248 Earth years", "365 Earth years"],
        answer: 2
      },
      {
        question: "Which planet is known as the 'Red Planet'?",
        options: ["Venus", "Mars", "Mercury", "Jupiter"],
        answer: 1
      }
      // Add more questions as needed
    ];

    let currentQuestionIndex = 0;
    let score = 0;

    function loadQuestion() {
      const currentQuestion = questions[currentQuestionIndex];
      document.getElementById("question").textContent = currentQuestion.question;
      const optionsDiv = document.getElementById("options");
      optionsDiv.innerHTML = "";

      currentQuestion.options.forEach((option, index) => {
        const optionDiv = document.createElement("div");
        optionDiv.textContent = option;
        optionDiv.className = "option";
        optionDiv.addEventListener("click", () => checkAnswer(index));
        optionsDiv.appendChild(optionDiv);
      });

      document.getElementById("result").style.display = "none";
      document.getElementById("next-button").style.display = "none";
    }

    function checkAnswer(selectedIndex) {
      const currentQuestion = questions[currentQuestionIndex];
      const resultDiv = document.getElementById("result");

      if (selectedIndex === currentQuestion.answer) {
        resultDiv.textContent = "Correct!";
        score++;
      } else {
        resultDiv.textContent = "Incorrect! The correct answer was: " + currentQuestion.options[currentQuestion.answer];
      }

      resultDiv.style.display = "block";
      document.getElementById("next-button").style.display = "block";
    }

    document.getElementById("next-button").addEventListener("click", () => {
      currentQuestionIndex++;
      if (currentQuestionIndex < questions.length) {
        loadQuestion();
      } else {
        showFinalScore();
      }
    });

    function showFinalScore() {
      document.getElementById("quiz-container").innerHTML = `
        <h1>Quiz Complete!</h1>
        <p>Your score: ${score} out of ${questions.length}</p>
        <p>Great job exploring the solar system!</p>
      `;
    }

    // Load the first question
    loadQuestion();
  </script>
</body>
</html>
