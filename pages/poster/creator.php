
    <aside class="editor">
      <header class="logo">
        <h1 class="hide">When the stars align.</h1>
        <a href=""><img src="images/assets/logo-black.png" alt="when the stars align."/></a>
      </header>
      <form method="post" action="index.php?page=upload<?php if(!empty($_GET["name"])) echo "&name=".$_GET["name"]; ?>" accept-charset="utf-8" name="upload-form">
        <input name="hidden_data" id='hidden_data' type="hidden" />
        <input name="message" type="hidden" id="save-message" value="<?php echo $message; ?>"/>
        <input name="color" type="hidden" id="save-color" value="<?php echo $color; ?>"/>
        <input name="date" type="hidden" id="save-date" value="<?php echo $date; ?>"/>
        <input name="email" type="hidden" id="save-email"/>
      </form>
      <form id="checkout" action="https://whenthestarsalign.com/cart/add/7365509644349" method="post" data-section="product-customizable-template">
        <div class="hide">
          <input type="text" id="Code" name="properties[Code]">
          <input type="text" id="Color" name="properties[Color]">
          <input type="text" id="NewDate" name="properties[Date]">
          <input type="text" id="Text" name="properties[Text]">
          <input type="text" id="Photo" name="properties[Photo]">
        </div>
        <div class="wrapper">
          <fieldset class="date slide">
            <label>Pick a special date</label>
            <input type="date" id="date" data-placeholder="What's your message" placeholder="What's your message" class="hide nativeDatePicker" />

            <div class="fallbackDatePicker">
              <span class="day">
              <select id="day" name="day">
              </select>
            </span>
              <span class="month">
              <select id="month" name="month">
                <option value="January">January</option>
                <option value="February">February</option>
                <option value="March">March</option>
                <option value="April">April</option>
                <option value="May">May</option>
                <option value="June">June</option>
                <option value="July">July</option>
                <option value="August">August</option>
                <option value="September">September</option>
                <option value="October">October</option>
                <option value="November">November</option>
                <option value="December">December</option>
              </select>
            </span>
              <span class="year">
              <select id="year" name="year">
              </select>
            </span>
            </div>
          </fieldset>
          <fieldset class="slide">
            <label for="message" class="animate">What's your message</label>
            <textarea id="message" name="message" data-placeholder="What's your message" placeholder="What's your message"></textarea>
          </fieldset>

          <fieldset id="colors" class="slide">
            <label for="message">Choose your style</label>
            <div>
              <input type="radio" name="color" class="color black" data-varient="7365509644349" value="0" checked/>
              <span class="black"></span>
            </div>
            <div>
              <input type="radio" name="color" class="color colored" data-varient="7433775153213" value="1" />
              <span class="colored"></span>
            </div>
            <div>
              <input type="radio" name="color" class="color black" data-varient="7433775218749" value="2" />
              <span class="red"></span>
            </div>
            <div>
              <input type="radio" name="color" class="color black" data-varient="7433775284285" value="3" />
              <span class="green"></span>
            </div>

            <div>
              <input type="radio" name="color" class="color black" data-varient="7433775153213" value="4" />
              <span class="white"></span>
            </div>
          </fieldset>
          <fieldset id="prints" class="slide">
            <label for="message">Print type</label>
            <div>
              <input type="radio" name="print" class="print" data-varient="7365509644349" value="0" checked/>
              <span>18" x 24"<br/>Art print</span>
            </div>
            <div>
              <input type="radio" name="print" class="print" data-varient="7433775153213" value="1" />
              <span>18" x 24"<br/>Framed Canvas</span>
            </div>
          </fieldset>
        </div>
        <div class="buttons-mobile">
          <input type="button" class="button prev" value="Prev" />
          <input type="button" class="button next" value="Next" />
          <input type="submit" id="download" class="download" value="Checkout">
        </div>
        <div class="buttons">
          <input type="submit" id="download" class="download" value="Checkout">
        </div>
      </form>
    </aside>
    <section class="designer">
      <canvas id="cnvs"></canvas>
    </section>
    <section class="preloader">
      <header>
        <h1 class="precentage">100%</h1>
        <h2 class="text">Creating Your Poster</h2>
      </header>
    </section>
