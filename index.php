<?php include 'includes/config.php' ?>

<?php
$videos = [
    ["src" => "cyber_video/cyber_picture1.jpg", "link" => "Services.php"],
    ["src" => "cyber_video/cyber_picture2.jpg", "link" => "questions.php"],
    ["src" => "cyber_video/cyber_picture3.jpg", "link" => "Services.php"]
];


?>


<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>CyberAnalyze</title>
  <link rel="stylesheet" href="style.css">
  
</head>
<body>
<?php include 'includes/header.php' ?>

<div class="slider-container">
  <div class="slider" id="slider">
    <div class="slider-inner" id="sliderInner">
      <?php foreach ($videos as $video): ?>
        <div class="slide">
        <img src="<?= $video['src'] ?>" alt="Cyber Image" class="slide-image">

          <a href="<?= $video['link'] ?>" class="overlay-button">Continue</a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <button class="nav-button left" onclick="scrollToPrev()">◀</button>
  <button class="nav-button right" onclick="scrollToNext()">▶</button>
</div>

<script>
  const sliderInner = document.getElementById('sliderInner');
  const totalSlides = document.querySelectorAll('.slide').length;
  let currentIndex = 0;

  function scrollToIndex(index) {
    sliderInner.style.transform = `translateX(-${index * 100}vw)`;
  }

  function scrollToNext() {
    currentIndex = (currentIndex + 1) % totalSlides;
    scrollToIndex(currentIndex);
  }

  function scrollToPrev() {
    currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
    scrollToIndex(currentIndex);
  }
</script>

</body>
</html>
