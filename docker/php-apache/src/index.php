<?php include __DIR__ . '/inc/header.php'; ?>

  <!-- main -->
  <div id="top-pic">
    <img src="./img/mountain.jpg" alt="top">
      <h1>進徳鑑</h1>
      <p>五術を活用するための鑑定サイト</p>
      <a href="./judge.php">
        <div class="top-btn btn">四柱推命を鑑定</div>
      </a>
  </div>
  <main>
    <div id="main">
      <h1>進徳鑑とは</h1>
      <p>　四柱推命を始めとした中国五術を活用するための鑑定サイトです。</p>
      <p>　サイト名として使用している『進徳鑑』は、高遠藩（長野県伊那市）に存在した藩校『進徳館』に準えております。</p>
      <p>　進徳館は易経にある「君子進徳修行、忠信所以進徳也」<sup>※</sup>という言葉に由来すると言われており、儒学を中心に漢学、医学、筆学、習礼、和漢西洋史、武学などについても教えていました。存続期間は、万延元年（1860年）から明治6年（1873年）のわずか13年間でしたが、その文武両道の優れた教育により、近代日本や長野県の教育界を支えた多くの人材を排出しました。</p>
      <p>　当サイトでは、日本で古くから活用されている中国五術を、現代で活用するために役立つツールを公開していきます。</p>
      <div class="cmt">
        <p>「立派な人格を持った人になるためには、徳を進め、学問や仕事を身につけなければならない。中心を尽くすことで、徳は進むのである」の意。</p>
      </div>

      <h1>鑑定ツール</h1>
      <div class="tool-wrapper">
        <div class="tool">
          <h2>命式診断</h2>
          <div class="img-center">
            <img src="./img/shichusuimei.jpg" alt="shichusuimei">
          </div>
          <p>生年月日時から四柱推命の命式を鑑定します。五行のバランス、大運の流れを確認することができます。</p>
        </div>
      </div>
    </div>
    <?php include './inc/side.php'; ?>
  </main>
  <!-- main -->

<?php include __DIR__ . '/inc/footer.php';
