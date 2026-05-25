<?php
include("connection.php");
function welcomeEmailTemplate($APP_NAME, $name, $BASE_URL, $FACEBOOK_URL, $INSTAGRAM_URL, $TWITTER_URL, $LANG = 'en'){
    if ($LANG == 'de') {

        return '
        <html>
  <head>
    <title>Welcome to ' . htmlspecialchars($APP_NAME) . ' !</title>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
      integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap"
      rel="stylesheet"
    />
    <style>
      body {
        font-family: "Poppins", Arial, sans-serif;
        line-height: 1.6;
        color: #333;
        padding: 20px;
        background-color: #f7f7f7;
      }
      .content {
        background-color: rgba(255, 255, 255, 0.95);
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      }
      h1 {
        color: #2b2b29;
        font-size: 28px;
        margin-bottom: 10px;
      }
      h3 {
        color: #2b2b29;
        font-size: 20px;
        margin-top: 20px;
      }
      p,
      li {
        color: #555;
        font-size: 16px;
        margin: 8px 0;
      }
      a {
        color: #f2af34;
        text-decoration: none;
      }
      .social-icons img {
        margin: 0 5px;
        width: 35px;
        height: 35px;
        transition: all 0.3s;
      }
      .social-icons img:hover {
        opacity: 0.7;
      } /* Mobile adjustments */
      @media (max-width: 768px) {
        h1 {
          font-size: 24px;
        }
        h3,
        p {
          font-size: 14px;
        }
        .content {
          padding: 15px;
        }
        .social-icons {
          text-align: center;
          margin-top: 10px;
        }
        .social-icons img {
          width: 30px;
          height: 30px;
        }
        table {
          background-image: none;
          background-color: #f7f7f7;
        }
      }
    </style>
  </head>
  <body>
    <table
      width="100%"
      cellpadding="0"
      cellspacing="0"
      style="
        background-image: url(\'' . $BASE_URL . 'API/uploads/email_backgroundd.jpg\');
        background-size: cover;
        padding: 20px;
        background-position: center;
      "
    >
      <tr>
        <td align="center">
          <table width="100%" class="content" style="max-width: 600px">
            <tr>
              <td align="center">
                <!-- Logo Section -->
                <img
                  src="' . $BASE_URL . 'admin_panel/images/logo.png"
                  alt="' . htmlspecialchars($APP_NAME) . '"
                  style="width: 100px; margin-bottom: 20px"
                />
              </td>
            </tr>
            <tr>
              <td>
                <h1>
                  Willkommen bei ' . htmlspecialchars($APP_NAME) . ' – Dein
                  Genuss startet jetzt! 🍕🎉
                </h1>
                <p>Hallo ' . htmlspecialchars($name) . ',</p>
                <p>
                  herzlich willkommen bei ' . htmlspecialchars($APP_NAME) . '!
                  🥳<br />
                  Schön, dass du da bist – wir freuen uns riesig, dich in
                  unserer Community von Pizza- und Burgerliebhabern zu begrüßen.
                </p>
                <h3>Warum du Foodola lieben wirst:</h3>
                <ul>
                  <li>
                    🍕 <strong>Höchste Qualität – ohne Kompromisse:</strong
                    ><br />
                    Unsere Speisen werden mit frischen, ausgewählten Zutaten
                    zubereitet. Qualität steht bei uns immer an erster Stelle –
                    und das schmeckt man!
                  </li>
                  <li>
                    🚀 <strong>Blitzschnelle Lieferung:</strong><br />
                    Dein Lieblingsessen kommt heiß und frisch direkt zu dir nach
                    Hause.
                  </li>
                  <li>
                    🤝 <strong>Service mit Herz:</strong><br />
                    Wir lieben, was wir tun – und das merkt man in jedem Bissen
                    und jedem Service!
                  </li>
                </ul>
                <h3>🎁 So holst du dir deinen Willkommensbonus:</h3>
                <p>
                  Du bekommst von uns ein kleines Geschenk zum Start!<br />So
                  einfach geht’s:
                </p>
                <ul>
                  <li>📱 Öffne unsere App</li>
                  <li>👤 Gehe in dein Profil</li>
                  <li>🏷️ Tippe auf "Promo-Code"</li>
                  <li>
                    🔓 Gib deinen Gutscheincode ein, um deinen Bonus zu
                    aktivieren
                  </li>
                </ul>
                <p>
                  💰 Deine Bonuspunkte werden automatisch deinem Wallet
                  gutgeschrieben – dort kannst du jederzeit deinen Punktestand
                  einsehen und bei deiner nächsten Bestellung verwenden.
                </p>
                <h3>📱 Exklusive Vorteile nur in unserer App:</h3>
                <ul>
                  <li>✅ 5 % Sofortrabatt auf jede Bestellung</li>
                  <li>💸 10 % Cashback bei jedem Einkauf</li>
                  <li>🌟 Optimale Nutzererfahrung dank einfacher Bedienung</li>
                  <li>🔔 Live-Updates zu jedem Schritt deiner Bestellung</li>
                </ul>
                <h3>Was jetzt zu tun ist:</h3>
                <ul>
                  <li>
                    👀
                    <a href="' . $BASE_URL . '">Entdecke unsere Speisekarte</a>
                    und finde deine Favoriten
                  </li>
                  <li>🛒 Bestelle direkt und genieße den Unterschied</li>
                </ul>
                <p>
                  Bei Fragen steht dir unser Support-Team gerne zur Seite – wir
                  sind immer für dich da!
                </p>
                <h4>Bleib mit uns in Kontakt:</h4>
                <p>
                  Verpasse keine Aktion und keine Neuigkeit – folge uns auf
                  Social Media!
                </p>
                <div class="social-icons">
                  <a
                    href="' . htmlspecialchars($FACEBOOK_URL) . '"
                    target="_blank"
                  >
                    <img
                      src="https://foodola.foodola.shop/API/uploads/facebook_logo.png"
                      alt="Facebook"
                    />
                  </a>
                  <a
                    href="' . htmlspecialchars($INSTAGRAM_URL) . '"
                    target="_blank"
                  >
                    <img
                      src="https://foodola.foodola.shop/API/uploads/instagram_logo.png"
                      alt="Instagram"
                    />
                  </a>
                  <a
                    href="' . htmlspecialchars($TWITTER_URL) . '"
                    target="_blank"
                  >
                    <img
                      src="https://foodola.foodola.shop/API/uploads/twitter_logo.png"
                      alt="Twitter"
                    />
                  </a>
                </div>
                <p>
                  Guten Appetit & viel Spaß beim Genießen!<br /><strong
                    >Dein ' . htmlspecialchars($APP_NAME) . ' Team 🍕</strong
                  >
                </p>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </body>
</html>
        ';
    } else {

        return '

        <html>
  <head>
    <title>Welcome to ' . htmlspecialchars($APP_NAME) . '!</title>

    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap"
      rel="stylesheet"
    />

    <style>
      body {
        font-family: "Poppins", Arial, sans-serif;
        line-height: 1.6;
        color: #333;
        padding: 20px;
        background-color: #f7f7f7;
      }
      .content {
        background-color: rgba(255, 255, 255, 0.95);
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      }
      h1 {
        color: #2b2b29;
        font-size: 28px;
        margin-bottom: 10px;
      }
      h3 {
        color: #2b2b29;
        font-size: 20px;
        margin-top: 20px;
      }
      p,
      li {
        color: #555;
        font-size: 16px;
        margin: 8px 0;
      }
      a {
        color: #f2af34;
        text-decoration: none;
      }
      .social-icons img {
        margin: 0 5px;
        width: 35px;
        height: 35px;
        transition: all 0.3s;
      }
      .social-icons img:hover {
        opacity: 0.7;
      }
      @media (max-width: 768px) {
        h1 {
          font-size: 24px;
        }
        h3,
        p {
          font-size: 14px;
        }
        .content {
          padding: 15px;
        }
        .social-icons {
          text-align: center;
          margin-top: 10px;
        }
        .social-icons img {
          width: 30px;
          height: 30px;
        }
        table {
          background-image: none;
          background-color: #f7f7f7;
        }
      }
    </style>
  </head>

  <body>
    <table
      width="100%"
      cellpadding="0"
      cellspacing="0"
      style="
        background-image: url(\'' . $BASE_URL . 'API/uploads/email_backgroundd.jpg\');
        background-size: cover;
        padding: 20px;
        background-position: center;
      "
    >
      <tr>
        <td align="center">
          <table width="100%" class="content" style="max-width: 600px">
            <!-- Logo -->
            <tr>
              <td align="center">
                <img
                  src="' . $BASE_URL . 'admin_panel/images/logo.png"
                  alt="' . htmlspecialchars($APP_NAME) . '"
                  style="width: 100px; margin-bottom: 20px"
                />
              </td>
            </tr>

            <!-- Content -->
            <tr>
              <td>
                <h1>
                  Welcome to ' . htmlspecialchars($APP_NAME) . ' – Your
                  enjoyment starts now! 🍕🎉
                </h1>

                <p>Hello ' . htmlspecialchars($name) . ',</p>

                <p>
                  A warm welcome to ' . htmlspecialchars($APP_NAME) . '! 🥳<br />
                  We’re glad you’re here – we’re excited to have you in our
                  community of pizza and burger lovers.
                </p>

                <h3>Why you’ll love Foodola:</h3>
                <ul>
                  <li>
                    🍕 <strong>Top quality – no compromises:</strong><br />
                    Our meals are prepared with fresh, carefully selected
                    ingredients. Quality is always our top priority – and you
                    can taste it!
                  </li>

                  <li>
                    🚀 <strong>Lightning-fast delivery:</strong><br />
                    Your favorite food arrives hot and fresh right at your
                    doorstep.
                  </li>

                  <li>
                    🤝 <strong>Service with heart:</strong><br />
                    We love what we do – and you’ll feel it in every bite and
                    every interaction!
                  </li>
                </ul>

                <h3>🎁 How to claim your welcome bonus:</h3>
                <p>You’ll receive a small gift to get started! Here’s how:</p>

                <ul>
                  <li>📱 Open our app</li>
                  <li>👤 Go to your profile</li>
                  <li>🏷️ Tap on "Promo Code"</li>
                  <li>🔓 Enter your voucher code to activate your bonus</li>
                </ul>

                <p>
                  💰 Your bonus points will be automatically added to your
                  wallet – you can check your balance anytime and use it for
                  your next order.
                </p>

                <h3>📱 Exclusive benefits in our app:</h3>
                <ul>
                  <li>✅ 5% instant discount on every order</li>
                  <li>💸 10% cashback on every purchase</li>
                  <li>🌟 Smooth and easy user experience</li>
                  <li>🔔 Live updates for every step of your order</li>
                </ul>

                <h3>What to do next:</h3>
                <ul>
                  <li>
                    👀 <a href="' . $BASE_URL . '">Explore our menu</a> and find
                    your favorites
                  </li>
                  <li>🛒 Order now and enjoy the difference</li>
                </ul>

                <p>
                  If you have any questions, our support team is always here to
                  help!
                </p>

                <h4>Stay connected with us:</h4>
                <p>
                  Don’t miss any offers or updates – follow us on social media!
                </p>

                <div class="social-icons">
                  <a
                    href="' . htmlspecialchars($FACEBOOK_URL) . '"
                    target="_blank"
                  >
                    <img
                      src="https://foodola.foodola.shop/API/uploads/facebook_logo.png"
                      alt="Facebook"
                    />
                  </a>
                  <a
                    href="' . htmlspecialchars($INSTAGRAM_URL) . '"
                    target="_blank"
                  >
                    <img
                      src="https://foodola.foodola.shop/API/uploads/instagram_logo.png"
                      alt="Instagram"
                    />
                  </a>
                  <a
                    href="' . htmlspecialchars($TWITTER_URL) . '"
                    target="_blank"
                  >
                    <img
                      src="https://foodola.foodola.shop/API/uploads/twitter_logo.png"
                      alt="Twitter"
                    />
                  </a>
                </div>

                <p>
                  Enjoy your meal & have a great time!<br />
                  <strong
                    >Your ' . htmlspecialchars($APP_NAME) . ' Team 🍕</strong
                  >
                </p>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </body>
</html>

       ';
    }
}

function orderAcceptedEmailTemplate($APP_NAME,$name,$order_id,$BASE_URL,$LANG = 'en') {



    if ($LANG == 'de') {

        return '
        
        <html>
  <head>
    <title>
      Ihre Bestellung wurde angenommen – ' . htmlspecialchars($APP_NAME) . '
    </title>
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap"
      rel="stylesheet"
    />
    <style>
      body {
        font-family: "Poppins", Arial, sans-serif;
        line-height: 1.6;
        color: #333;
        padding: 20px;
        background-color: #f7f7f7;
      }
      .content {
        background-color: rgba(255, 255, 255, 0.95);
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      }
      h1 {
        color: #2b2b29;
        font-size: 28px;
        margin-bottom: 10px;
      }
      h3 {
        color: #2b2b29;
        font-size: 20px;
        margin-top: 20px;
      }
      p,
      li {
        color: #555;
        font-size: 16px;
        margin: 8px 0;
      }
      a {
        color: #f2af34;
        text-decoration: none;
      }
    </style>
  </head>
  <body>
    <table
      width="100%"
      cellpadding="0"
      cellspacing="0"
      style="
        background-image: url(\'' . $BASE_URL . 'API/uploads/email_backgroundd.jpg\');
        background-size: cover;
        padding: 20px;
        background-position: center;
      "
    >
      <tr>
        <td align="center">
          <table width="100%" class="content" style="max-width: 600px">
            <tr>
              <td align="center">
                <img
                  src="' . $BASE_URL . 'admin_panel/images/logo.png"
                  alt="'. htmlspecialchars($APP_NAME) .'"
                  style="width: 100px; margin-bottom: 20px"
                />
              </td>
            </tr>
            <tr>
              <td>
                <h1>Ihre Bestellung wurde angenommen!</h1>
                <p>Hallo <strong>' . htmlspecialchars($name) . '</strong>,</p>
                <p>
                  Vielen Dank für Ihre Bestellung bei
                  <strong>' . htmlspecialchars($APP_NAME) . '</strong>.
                </p>
                <p>
                  <strong>Bestellnummer:</strong> ' .
                  htmlspecialchars($order_id) . '
                </p>
                <p>
                  Ihre Bestellung wurde erfolgreich angenommen und wird in Kürze
                  bearbeitet.
                </p>
                <h3>Was kommt als Nächstes?</h3>
                <ul>
                  <li>
                    Unser Team bereitet Ihre Bestellung mit größter Sorgfalt zu.
                  </li>
                  <li>
                    Sie erhalten eine Benachrichtigung, sobald Ihre Bestellung
                    unterwegs ist.
                  </li>
                </ul>
                <p>Bei Fragen stehen wir Ihnen jederzeit zur Verfügung.</p>
                <p>
                  Mit freundlichen Grüßen,<br />Ihr ' .
                  htmlspecialchars($APP_NAME) . ' Team
                </p>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </body>
</html>

';

    } else {

        return '
        
<html>
<head>
    <title>Your Order Has Been Accepted – ' . htmlspecialchars($APP_NAME) . '</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: "Poppins", Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            padding: 20px;
            background-color: #f7f7f7;
        }
        .content {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #2B2B29;
            font-size: 28px;
            margin-bottom: 10px;
        }
        h3 {
            color: #2B2B29;
            font-size: 20px;
            margin-top: 20px;
        }
        p, li {
            color: #555;
            font-size: 16px;
            margin: 8px 0;
        }
        a {
            color: #F2AF34;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <table width="100%" cellpadding="0" cellspacing="0" style="background-image: url(\'' . $BASE_URL . 'API/uploads/email_backgroundd.jpg\'); background-size: cover; padding: 20px; background-position: center;">
        <tr>
            <td align="center">
                <table width="100%" class="content" style="max-width: 600px;">
                    
                    <!-- Logo -->
                    <tr>
                        <td align="center">
                            <img src="' . $BASE_URL . 'admin_panel/images/logo.png" alt="'. htmlspecialchars($APP_NAME) .'" style="width: 100px; margin-bottom: 20px;">
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td>
                            <h1>Your Order Has Been Accepted!</h1>

                            <p>Hello <strong>' . htmlspecialchars($name) . '</strong>,</p>

                            <p>Thank you for your order with <strong>' . htmlspecialchars($APP_NAME) . '</strong>.</p>

                            <p><strong>Order Number:</strong> ' . htmlspecialchars($order_id) . '</p>

                            <p>Your order has been successfully accepted and will be processed shortly.</p>

                            <h3>What happens next?</h3>
                            <ul>
                                <li>Our team will prepare your order with the utmost care.</li>
                                <li>You will receive a notification once your order is on the way.</li>
                            </ul>

                            <p>If you have any questions, feel free to contact us anytime.</p>

                            <p>
                                Best regards,<br>
                                Your ' . htmlspecialchars($APP_NAME) . ' Team
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
';

    }
}

function orderDeliveredEmailTemplate($APP_NAME,$name,$order_id,$BASE_URL,$LANG = 'en') {


    if ($LANG == 'de') {

        return '
        
        <html>
  <head>
    <title>
      Ihre Bestellung wurde geliefert – ' . htmlspecialchars($APP_NAME) . '
    </title>
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap"
      rel="stylesheet"
    />
    <style>
      body {
        font-family: "Poppins", Arial, sans-serif;
        line-height: 1.6;
        color: #333;
        padding: 20px;
        background-color: #f7f7f7;
      }
      .content {
        background-color: rgba(255, 255, 255, 0.95);
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      }
      h1 {
        color: #2b2b29;
        font-size: 28px;
        margin-bottom: 10px;
      }
      h3 {
        color: #2b2b29;
        font-size: 20px;
        margin-top: 20px;
      }
      p,
      li {
        color: #555;
        font-size: 16px;
        margin: 8px 0;
      }
      a {
        color: #f2af34;
        text-decoration: none;
      }
    </style>
  </head>
  <body>
    <table
      width="100%"
      cellpadding="0"
      cellspacing="0"
      style="
        background-image: url(\'' . $BASE_URL . 'API/uploads/email_backgroundd.jpg\');
        background-size: cover;
        padding: 20px;
        background-position: center;
      "
    >
      <tr>
        <td align="center">
          <table width="100%" class="content" style="max-width: 600px">
            <tr>
              <td align="center">
                <img
                  src="' . $BASE_URL . 'admin_panel/images/logo.png"
                  alt="'. htmlspecialchars($APP_NAME) .'"
                  style="width: 100px; margin-bottom: 20px"
                />
              </td>
            </tr>
            <tr>
              <td>
                <h1>Ihre Bestellung wurde geliefert!</h1>
                <p>Hallo <strong>' . htmlspecialchars($name) . '</strong>,</p>
                <p>
                  Wir freuen uns, Ihnen mitteilen zu können, dass Ihre
                  Bestellung erfolgreich geliefert wurde.
                </p>
                <p>
                  <strong>Bestellnummer:</strong> #' .
                  htmlspecialchars($order_id) . '
                </p>
                <h3>Guten Appetit!</h3>
                <p>
                  Wir hoffen, dass Sie Ihr Essen genießen. Vielen Dank, dass Sie
                  bei
                  <strong>' . htmlspecialchars($APP_NAME) . '</strong> bestellt
                  haben.
                </p>
                <p>
                  Wenn Sie Fragen haben oder Feedback geben möchten, stehen wir
                  Ihnen jederzeit zur Verfügung.
                </p>
                <p>
                  Mit freundlichen Grüßen,<br />Ihr ' .
                  htmlspecialchars($APP_NAME) . ' Team
                </p>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </body>
</html>

';

    } else {

        return '
<html>
<head>
    <title>Your Order Has Been Delivered – ' . htmlspecialchars($APP_NAME) . '</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: "Poppins", Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            padding: 20px;
            background-color: #f7f7f7;
        }
        .content {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        h1 { color: #2B2B29; font-size: 28px; margin-bottom: 10px; }
        h3 { color: #2B2B29; font-size: 20px; margin-top: 20px; }
        p, li { color: #555; font-size: 16px; margin: 8px 0; }
        a { color: #F2AF34; text-decoration: none; }
    </style>
</head>

<body>
    <table width="100%" cellpadding="0" cellspacing="0" style="background-image: url(\'' . $BASE_URL . 'API/uploads/email_backgroundd.jpg\'); background-size: cover; padding: 20px; background-position: center;">
        <tr>
            <td align="center">
                <table width="100%" class="content" style="max-width: 600px;">
                    
                    <!-- Logo -->
                    <tr>
                        <td align="center">
                            <img src="' . $BASE_URL . 'admin_panel/images/logo.png" alt="'. htmlspecialchars($APP_NAME) .'" style="width: 100px; margin-bottom: 20px;">
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td>
                            <h1>Your Order Has Been Delivered!</h1>

                            <p>Hello <strong>' . htmlspecialchars($name) . '</strong>,</p>

                            <p>We’re happy to inform you that your order has been successfully delivered.</p>

                            <p><strong>Order Number:</strong> #' . htmlspecialchars($order_id) . '</p>

                            <h3>Enjoy your meal!</h3>

                            <p>
                                We hope you enjoy your food. Thank you for ordering from 
                                <strong>' . htmlspecialchars($APP_NAME) . '</strong>.
                            </p>

                            <p>
                                If you have any questions or would like to share feedback, feel free to contact us anytime.
                            </p>

                            <p>
                                Best regards,<br>
                                Your ' . htmlspecialchars($APP_NAME) . ' Team
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>

';

    }
}

function newOrderEmailTemplate($APP_NAME,$BASE_URL,$last_order_id,$user_name,$address,$total_amount,$shipping_cost,$payment_type,$additionalNotes,$datetime,$LANG = 'en') {



    if ($LANG == 'de') {

        return '
        
        <html>
  <head>
    <title>Neue Bestellung erhalten</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        padding: 20px;
      }
      .email-container {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      }
      .header {
        text-align: center;
        margin-bottom: 20px;
      }
      .order-details {
        font-size: 16px;
        line-height: 1.5;
      }
      .order-details strong {
        color: #333;
      }
      .view-button {
        display: inline-block;
        margin-top: 20px;
        background-color: #f2af34;
        color: #fff;
        padding: 12px 20px;
        text-decoration: none;
        border-radius: 6px;
        font-weight: bold;
      }
      .footer {
        margin-top: 30px;
        font-size: 14px;
        color: #777;
        text-align: center;
      }
    </style>
  </head>
  <body>
    <div class="email-container">
      <div class="header">
        <img
          src="' . $BASE_URL . 'admin_panel/images/logo.png"
          alt="' . htmlspecialchars($APP_NAME) . '"
          style="width: 100px"
        />
        <h2>Neue Bestellung erhalten</h2>
      </div>
      <div class="order-details">
        <p><strong>Bestellnummer:</strong> ' . $last_order_id . '</p>
        <p><strong>Kunde:</strong> ' . htmlspecialchars($user_name) . '</p>
        <p><strong>Adresse:</strong> ' . htmlspecialchars($address) . '</p>
        <p>
          <strong>Gesamtpreis:</strong> €' . number_format(($total_amount +
         $shipping_cost), 2) . '
        </p>
        <p>
          <strong>Versandkosten:</strong> €' . number_format($shipping_cost, 2)
          . '
        </p>
        <p>
          <strong>Zahlungsart:</strong> ' . htmlspecialchars($payment_type) . '
        </p>
        <p>
          <strong>Zusätzliche Hinweise:</strong> ' .
          htmlspecialchars($additionalNotes) . '
        </p>
        <p>
          <strong>Bestelldatum:</strong> ' . htmlspecialchars($datetime) . '
        </p>
        <a
          class="view-button"
          href="' . $BASE_URL . 'admin_panel/order_details.php?order_id=' . $last_order_id . '"
          target="_blank"
        >
          Bestellung anzeigen
        </a>
      </div>
      <div class="footer">
        <p>
          Diese E-Mail wurde automatisch ' . htmlspecialchars($APP_NAME) . '
          generiert.
        </p>
      </div>
    </div>
  </body>
</html>

';

    } else {

        return '

<html>
<head>
    <title>New Order Received</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .email-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .order-details {
            font-size: 16px;
            line-height: 1.5;
        }
        .order-details strong {
            color: #333;
        }
        .view-button {
            display: inline-block;
            margin-top: 20px;
            background-color: #F2AF34;
            color: #fff;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #777;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
           <img src="' . $BASE_URL . 'admin_panel/images/logo.png" alt="' . htmlspecialchars($APP_NAME) . '" style="width: 100px;">
            <h2>New Order Received</h2>
        </div>

        <div class="order-details">
            <p><strong>Order Number:</strong> ' . $last_order_id . '</p>
            <p><strong>Customer:</strong> ' . htmlspecialchars($user_name) . '</p>
            <p><strong>Address:</strong> ' . htmlspecialchars($address) . '</p>
            <p><strong>Total Price:</strong> €' . number_format(($total_amount + $shipping_cost), 2) . '</p>
            <p><strong>Shipping Cost:</strong> €' . number_format($shipping_cost, 2) . '</p>
            <p><strong>Payment Method:</strong> ' . htmlspecialchars($payment_type) . '</p>
            <p><strong>Additional Notes:</strong> ' . htmlspecialchars($additionalNotes) . '</p>
            <p><strong>Order Date:</strong> ' . htmlspecialchars($datetime) . '</p>

            <a class="view-button" href="' . $BASE_URL . 'admin_panel/order_details.php?order_id=' . $last_order_id . '" target="_blank">
                View Order
            </a>
        </div>

        <div class="footer">
            <p>This email was automatically generated by ' . htmlspecialchars($APP_NAME) . '.</p>
        </div>
    </div>
</body>
</html>

';

    }
}

function reservationPendingEmailTemplate($APP_NAME,$name,$reservation_date,$reservation_time,$persons,$BASE_URL,$LANG = 'en') {
    if ($LANG == 'de') {

        return '
        <html>
  <body
    style="
      font-family: Poppins, Arial, sans-serif;
      line-height: 1.6;
      color: #333;
      padding: 20px;
      background-color: #f7f7f7;
    "
  >
    <table
      width="100%"
      cellpadding="0"
      cellspacing="0"
      style="
        background-image: url(\'' . $BASE_URL . 'API/uploads/email_backgroundd.jpg\');
        background-size: cover;
        padding: 20px;
        background-position: center;
      "
    >
      <tr>
        <td align="center">
          <table
            width="100%"
            class="content"
            style="
              max-width: 600px;
              background-color: rgba(255, 255, 255, 0.95);
              padding: 20px;
              border-radius: 8px;
              box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            "
          >
            <tr>
              <td align="center">
                <img
                  src="' . $BASE_URL . 'admin_panel/images/logo.png"
                  alt="' . htmlspecialchars($APP_NAME) . '"
                  style="width: 100px; margin-bottom: 20px"
                />
              </td>
            </tr>
            <tr>
              <td>
                <p>Sehr geehrte Frau ' . htmlspecialchars($name) . ',</p>
                <p>
                  Vielen Dank für Ihre Reservierung bei
                  <strong>' . $APP_NAME . '</strong>.<br />
                  Wir werden Ihnen so schnell wie möglich eine
                  Bestätigungs-E-Mail für Ihre Reservierung zusenden.
                </p>
                <p>
                  <strong>Datum:</strong> ' . $reservation_date . '<br />
                  <strong>Uhrzeit:</strong> ' . $reservation_time . ' Uhr<br />
                  <strong>Personenanzahl:</strong> ' . $persons . ' Personen
                </p>
                <p>
                  Bei Fragen oder Änderungswünschen stehen wir Ihnen jederzeit
                  gerne zur Verfügung.
                </p>
                <p>Mit freundlichen Grüßen,<br />Ihr ' . $APP_NAME . ' Team</p>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </body>
</html>

        
';

    } else {

 return '
<html>
<body style="font-family: Poppins, Arial, sans-serif; line-height: 1.6; color: #333; padding: 20px; background-color: #f7f7f7;">
<table width="100%" cellpadding="0" cellspacing="0" style="background-image: url(' . $BASE_URL . 'API/uploads/email_backgroundd.jpg); background-size: cover; padding: 20px; background-position: center;">
    <tr><td align="center">
        <table width="100%" class="content" style="max-width: 600px; background-color: rgba(255,255,255,0.95); padding: 20px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
            <tr><td align="center">
                <img src="' . $BASE_URL . 'admin_panel/images/logo.png" alt="' . htmlspecialchars($APP_NAME) . '" style="width: 100px; margin-bottom: 20px;">
            </td></tr>
            <tr><td>
                <p>Dear Ms. ' . htmlspecialchars($name) . ',</p>
                <p>Thank you for your reservation at <strong>' . $APP_NAME . '</strong>.<br>
                We will send you a confirmation email for your reservation as soon as possible.</p>
                <p>
                <strong>Date:</strong> ' . $reservation_date . '<br>
                <strong>Time:</strong> ' . $reservation_time . ' hrs<br>
                <strong>Number of Guests:</strong> ' . $persons . ' persons
                </p>
                <p>If you have any questions or would like to make changes, please feel free to contact us at any time.</p>
                <p>Kind regards,<br>Your ' . $APP_NAME . ' Team</p>
            </td></tr>
        </table>
    </td></tr>
</table>
</body>
</html>
';

    }
}

function reservationConfirmedEmailTemplate($APP_NAME,$name,$reservation_date,$reservation_time,$persons,$BASE_URL,$LANG = 'en') {

    if ($LANG == 'de') {

        return '
        
        <html>
  <body
    style="
      font-family: Poppins, Arial, sans-serif;
      line-height: 1.6;
      color: #333;
      padding: 20px;
      background-color: #f7f7f7;
    "
  >
    <table
      width="100%"
      cellpadding="0"
      cellspacing="0"
      style="
        background-image: url(\'' . $BASE_URL . 'API/uploads/email_backgroundd.jpg\');
        background-size: cover;
        padding: 20px;
        background-position: center;
      "
    >
      <tr>
        <td align="center">
          <table
            width="100%"
            class="content"
            style="
              max-width: 600px;
              background-color: rgba(255, 255, 255, 0.95);
              padding: 20px;
              border-radius: 8px;
              box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            "
          >
            <tr>
              <td align="center">
                <img
                  src="' . $BASE_URL . 'admin_panel/images/logo.png"
                  alt="' . htmlspecialchars($APP_NAME) . '"
                  style="width: 100px; margin-bottom: 20px"
                />
              </td>
            </tr>
            <tr>
              <td>
                <p>Sehr geehrte Frau ' . htmlspecialchars($name) . ',</p>
                <p>
                  Vielen Dank für Ihre Reservierung bei
                  <strong>' . $APP_NAME . '</strong>.<br />
                  Gerne bestätigen wir Ihnen Ihre Reservierung wie folgt:
                </p>
                <p>
                  <strong>Datum:</strong> ' . $reservation_date . '<br />
                  <strong>Uhrzeit:</strong> ' . $reservation_time . ' Uhr<br />
                  <strong>Personenanzahl:</strong> ' . $persons . ' Personen
                </p>
                <p>
                  Wir freuen uns, Sie bei uns im Restaurant begrüßen zu
                  dürfen.<br />
                  Bei Fragen oder Änderungswünschen stehen wir Ihnen jederzeit
                  gerne zur Verfügung.
                </p>
                <p>Mit freundlichen Grüßen,<br />Ihr ' . $APP_NAME . ' Team</p>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </body>
</html>

';

    } else {

        return '
<html>
<body style="font-family: Poppins, Arial, sans-serif; line-height: 1.6; color: #333; padding: 20px; background-color: #f7f7f7;">
<table width="100%" cellpadding="0" cellspacing="0" style="background-image: url(\'' . $BASE_URL . 'API/uploads/email_backgroundd.jpg\'); background-size: cover; padding: 20px; background-position: center;">
    <tr>
        <td align="center">
            <table width="100%" class="content" style="max-width: 600px; background-color: rgba(255,255,255,0.95); padding: 20px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">

                <tr>
                    <td align="center">
                        <img src="' . $BASE_URL . 'admin_panel/images/logo.png" alt="' . htmlspecialchars($APP_NAME) . '" style="width: 100px; margin-bottom: 20px;">
                    </td>
                </tr>

                <tr>
                    <td>
                        <p>Dear Mrs. ' . htmlspecialchars($name) . ',</p>

                        <p>
                            Thank you for your reservation at <strong>' . $APP_NAME . '</strong>.<br>
                            We are pleased to confirm your reservation as follows:
                        </p>

                        <p>
                            <strong>Date:</strong> ' . $reservation_date . '<br>
                            <strong>Time:</strong> ' . $reservation_time . ' hrs<br>
                            <strong>Number of Guests:</strong> ' . $persons . ' persons
                        </p>

                        <p>
                            We look forward to welcoming you to our restaurant.<br>
                            If you have any questions or would like to make changes, please feel free to contact us anytime.
                        </p>

                        <p>
                            Best regards,<br>
                            Your ' . $APP_NAME . ' Team
                        </p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>
</body>
</html>
';

    }
}

function reservationCancelledTemplate($APP_NAME, $name, $BASE_URL, $reservation_date, $reservation_time, $LANG = 'en'){
    
    if ($LANG == 'de') {

        return '
        
       <html> <body style="font-family: Poppins, Arial, sans-serif; line-height: 1.6; color: #333; padding: 20px; background-color: #f7f7f7;"> <table width="100%" cellpadding="0" cellspacing="0" style="background-image: url(\'' . $BASE_URL . 'API/uploads/email_backgroundd.jpg\'); background-size: cover; padding: 20px; background-position: center;"> <tr><td align="center"> <table width="100%" class="content" style="max-width: 600px; background-color: rgba(255,255,255,0.95); padding: 20px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);"> <tr><td align="center"> <img src="' . $BASE_URL . 'admin_panel/images/logo.png" alt="' . htmlspecialchars($APP_NAME) . '" style="width: 100px; margin-bottom: 20px;"> </td></tr> <tr> <td> <p>Sehr geehrte ' . htmlspecialchars($name) . ' ,</p> <p> leider müssen wir Ihre Reservierung am <strong>' . $reservation_date . '</strong> um <strong>' . $reservation_time . ' Uhr</strong> stornieren. Wir bitten die Unannehmlichkeiten zu entschuldigen. </p> <p> Gerne nehmen wir jederzeit eine neue Reservierung für Sie entgegen oder helfen Ihnen, einen alternativen Termin zu finden. Sie können uns telefonisch kontaktieren. </p> <p> Mit freundlichen Grüßen<br> Ihr ' . $APP_NAME . ' Team </p> </td> </tr> </table> </body> </html>
';

    } else {

        return '
<html>
<body style="font-family: Poppins, Arial, sans-serif; line-height: 1.6; color: #333; padding: 20px; background-color: #f7f7f7;">
<table width="100%" cellpadding="0" cellspacing="0" style="background-image: url(\'' . $BASE_URL . 'API/uploads/email_backgroundd.jpg\'); background-size: cover; padding: 20px; background-position: center;">
    <tr>
        <td align="center">
            <table width="100%" class="content" style="max-width: 600px; background-color: rgba(255,255,255,0.95); padding: 20px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">

                <tr>
                    <td align="center">
                        <img src="' . $BASE_URL . 'admin_panel/images/logo.png" alt="' . htmlspecialchars($APP_NAME) . '" style="width: 100px; margin-bottom: 20px;">
                    </td>
                </tr>

                <tr>
                    <td>
                        <p>Dear ' . htmlspecialchars($name) . ',</p>

                        <p>
                            Unfortunately, we have to cancel your reservation on 
                            <strong>' . $reservation_date . '</strong> at 
                            <strong>' . $reservation_time . ' hrs</strong>.
                            We sincerely apologize for the inconvenience.
                        </p>

                        <p>
                            We would be happy to accept a new reservation for you at any time
                            or help you find an alternative date. You can also contact us by phone.
                        </p>

                        <p>
                            Best regards,<br>
                            Your ' . $APP_NAME . ' Team
                        </p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>
</body>
</html>
';

    }
}

function newReservationAdminTemplate($APP_NAME,$name,$email,$BASE_URL,$reservation_date,$reservation_time,$people, $LANG = 'en') {
     if ($LANG == 'de') {

        return '
            <html>
              <body
                style="
                  font-family: Poppins, Arial, sans-serif;
                  line-height: 1.6;
                  color: #333;
                  padding: 20px;
                  background-color: #f7f7f7;
                "
              >
                <table
                  width="100%"
                  cellpadding="0"
                  cellspacing="0"
                  style="
                    background-image: url(\''.$BASE_URL.'API/uploads/email_backgroundd.jpg\');
                    background-size: cover;
                    padding: 20px;
                    background-position: center;
                  "
                >
                  <tr>
                    <td align="center">
                      <table
                        width="100%"
                        class="content"
                        style="
                          max-width: 600px;
                          background-color: rgba(255, 255, 255, 0.95);
                          padding: 20px;
                          border-radius: 8px;
                          box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                        "
                      >
                        <tr>
                          <td align="center">
                            <img
                              src="'.$BASE_URL.'admin_panel/images/logo.png"
                              alt="'.htmlspecialchars($APP_NAME).'"
                              style="width: 100px; margin-bottom: 20px"
                            />
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <p><strong>Neue Reservierung eingegangen</strong></p>
                            <p>
                              Eine neue Reservierung wurde soeben erstellt. Details siehe
                              unten:
                            </p>
                            <p>
                              <strong>Name:</strong> '.htmlspecialchars($name).'<br />
                              <strong>E-Mail:</strong> '.htmlspecialchars($email).'<br />
                              <strong>Datum:</strong> '.$reservation_date.'<br />
                              <strong>Uhrzeit:</strong> '.$reservation_time.' Uhr<br />
                              <strong>Personenanzahl:</strong> '.$people.' Personen
                            </p>
                            <p>Bitte prüfen Sie die Reservierung im Admin-Panel.</p>
                            <p>
                              Mit freundlichen Grüßen,<br />
                              '.$APP_NAME.' System
                            </p>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </body>
            </html>

            ';

    } else {
        return '
<html>
<body style="font-family: Poppins, Arial, sans-serif; line-height: 1.6; color: #333; padding: 20px; background-color: #f7f7f7;">
<table width="100%" cellpadding="0" cellspacing="0" style="background-image: url(\''.$BASE_URL.'API/uploads/email_backgroundd.jpg\'); background-size: cover; padding: 20px; background-position: center;">
    <tr>
        <td align="center">
            <table width="100%" class="content" style="max-width: 600px; background-color: rgba(255,255,255,0.95); padding: 20px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">

                <tr>
                    <td align="center">
                        <img src="'.$BASE_URL.'admin_panel/images/logo.png" alt="'.htmlspecialchars($APP_NAME).'" style="width: 100px; margin-bottom: 20px;">
                    </td>
                </tr>

                <tr>
                    <td>
                        <p><strong>New Reservation Received</strong></p>

                        <p>A new reservation has just been created. Details are shown below:</p>

                        <p>
                            <strong>Name:</strong> '.htmlspecialchars($name).'<br>
                            <strong>Email:</strong> '.htmlspecialchars($email).'<br>
                            <strong>Date:</strong> '.$reservation_date.'<br>
                            <strong>Time:</strong> '.$reservation_time.' hrs<br>
                            <strong>Number of Guests:</strong> '.$people.' persons
                        </p>

                        <p>Please review the reservation in the admin panel.</p>

                        <p>
                            Best regards,<br>
                            '.$APP_NAME.' System
                        </p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>
</body>
</html>
';

    }
}

function reservationConfirmationTemplate($APP_NAME,$name,$BASE_URL,$reservation_date,$reservation_time,$persons, $LANG = 'en') {
      if ($LANG == 'de') {

        return '
           <html> <body style="font-family: Poppins, Arial, sans-serif; line-height: 1.6; color: #333; padding: 20px; background-color: #f7f7f7;"> <table width="100%" cellpadding="0" cellspacing="0" style="background-image: url(\''.$BASE_URL.'API/uploads/email_backgroundd.jpg\'); background-size: cover; padding: 20px; background-position: center;"> <tr><td align="center"> <table width="100%" class="content" style="max-width: 600px; background-color: rgba(255,255,255,0.95); padding: 20px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);"> <tr><td align="center"> <img src="'.$BASE_URL.'admin_panel/images/logo.png" alt="'.htmlspecialchars($APP_NAME).'" style="width: 100px; margin-bottom: 20px;"> </td></tr> <tr><td> <p>Sehr geehrte Frau '.htmlspecialchars($name).',</p> <p>Vielen Dank für Ihre Reservierung bei <strong>'.$APP_NAME.'</strong>.<br> Gerne bestätigen wir Ihnen Ihre Reservierung wie folgt:</p> <p> <strong>Datum:</strong> '.$reservation_date.'<br> <strong>Uhrzeit:</strong> '.$reservation_time.' Uhr<br> <strong>Personenanzahl:</strong> '.$persons.' Personen </p> <p>Mit freundlichen Grüßen,<br>Ihr '.$APP_NAME.' Team</p> </td></tr> </table> </body> </html>
            ';

    } else {
        return '
<html>
<body style="font-family: Poppins, Arial, sans-serif; line-height: 1.6; color: #333; padding: 20px; background-color: #f7f7f7;">
<table width="100%" cellpadding="0" cellspacing="0" style="background-image: url(\''.$BASE_URL.'API/uploads/email_backgroundd.jpg\'); background-size: cover; padding: 20px; background-position: center;">
    <tr>
        <td align="center">
            <table width="100%" class="content" style="max-width: 600px; background-color: rgba(255,255,255,0.95); padding: 20px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">

                <tr>
                    <td align="center">
                        <img src="'.$BASE_URL.'admin_panel/images/logo.png" alt="'.htmlspecialchars($APP_NAME).'" style="width: 100px; margin-bottom: 20px;">
                    </td>
                </tr>

                <tr>
                    <td>
                        <p>Dear Mrs. '.htmlspecialchars($name).',</p>

                        <p>
                            Thank you for your reservation at <strong>'.$APP_NAME.'</strong>.<br>
                            We are pleased to confirm your reservation as follows:
                        </p>

                        <p>
                            <strong>Date:</strong> '.$reservation_date.'<br>
                            <strong>Time:</strong> '.$reservation_time.' hrs<br>
                            <strong>Number of Guests:</strong> '.$persons.' persons
                        </p>

                        <p>
                            Best regards,<br>
                            Your '.$APP_NAME.' Team
                        </p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>
</body>
</html>
';

    }
}

function newsGiftTemplate($APP_NAME,$name,$BASE_URL,$FACEBOOK_URL,$INSTAGRAM_URL,$TWITTER_URL,$points,$LANG = 'en') {
      if ($LANG == 'de') {

        return '
  <html> <head> <title>News from ' . htmlspecialchars($APP_NAME) . ' !</title> <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" /> <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet"> <style> body { font-family: "Poppins", Arial, sans-serif; line-height: 1.6; color: #333; padding: 20px; background-color: #f7f7f7; } .content { background-color: rgba(255, 255, 255, 0.95); padding: 20px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); } h1 { color: #2B2B29; font-size: 28px; margin-bottom: 10px; } h3 { color: #2B2B29; font-size: 20px; margin-top: 20px; } p, li { color: #555; font-size: 16px; margin: 8px 0; } a { color: #F2AF34; text-decoration: none; } .social-icons img { margin: 0 5px; width: 35px; height: 35px; transition: all 0.3s; } .social-icons img:hover { opacity: 0.7; } /* Mobile adjustments */ @media (max-width: 768px) { h1 { font-size: 24px; } h3, p { font-size: 14px; } .content { padding: 15px; } .social-icons { text-align: center; margin-top: 10px; } .social-icons img { width: 30px; height: 30px; } table { background-image: none; background-color: #f7f7f7; } } </style> </head> <body> <table width="100%" cellpadding="0" cellspacing="0" style="background-image: url(\'' . $BASE_URL . 'API/uploads/email_backgroundd.jpg\'); background-size: cover; padding: 20px; background-position: center;"> <tr> <td align="center"> <table width="100%" class="content" style="max-width: 600px;"> <tr> <td align="center"> <!-- Logo Section --> <img src="' . $BASE_URL . 'admin_panel/images/logo.png" alt="'. htmlspecialchars($APP_NAME) .'" style="width: 100px; margin-bottom: 20px;"> </td> </tr> <tr> <td> <h1>Lieber '. htmlspecialchars($APP_NAME) . ' Nutzer – Du hast ein Geschenk erhalten 🍕🎉</h1> <p>Hallo ' . htmlspecialchars($name) . ',</p> <p>wir haben heute eine kleine Überraschung für dich! 🎉<br> Als Dankeschön für deine Treue haben wir dir ['.htmlspecialchars($points).' '.htmlspecialchars($APP_NAME).' Coins] geschenkt – ganz ohne Bedingungen. 💛<br> 👉 Dein Vorteil: Nutze deine Coins bei deiner nächsten Bestellung und spare direkt beim Bezahlen. </p> <h3>Aber aufgepasst ⏳</h3> <ul> <li>Diese Aktion ist nur für kurze Zeit gültig. Verpasse also nicht die Chance, dir dein Lieblingsessen günstiger zu sichern!</li> </ul> <h3>Warum warten/h3> <ul> <li>Bestelle jetzt und löse dein Geschenk direkt ein 🍕🍔</li> </ul> <li>👀 <a href="' .$BASE_URL. '">Jetzt bestellen</a> und finde deine Favoriten</li> <p>Wir freuen uns darauf, dich wieder zu beliefern!</p> <h4>Bleib mit uns in Kontakt:</h4> <p>Verpasse keine Aktion und keine Neuigkeit – folge uns auf Social Media!</p> <div class="social-icons"> <a href="' . htmlspecialchars($FACEBOOK_URL) . '" target="_blank"> <img src="https://foodola.foodola.shop/API/uploads/facebook_logo.png" alt="Facebook"> </a> <a href="' . htmlspecialchars($INSTAGRAM_URL) . '" target="_blank"> <img src="https://foodola.foodola.shop/API/uploads/instagram_logo.png" alt="Instagram"> </a> <a href="' . htmlspecialchars($TWITTER_URL) . '" target="_blank"> <img src="https://foodola.foodola.shop/API/uploads/twitter_logo.png" alt="Twitter"> </a> </div> <p>Guten Appetit & viel Spaß beim Genießen!<br><strong>Dein ' . htmlspecialchars($APP_NAME) . ' Team 🍕</strong></p> </td> </tr> </table> </td> </tr> </table> </body> </html>
            ';

    } else {
        return '
<html>
<head>
    <title>News from ' . htmlspecialchars($APP_NAME) . '!</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: "Poppins", Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            padding: 20px;
            background-color: #f7f7f7;
        }
        .content {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #2B2B29;
            font-size: 28px;
            margin-bottom: 10px;
        }
        h3 {
            color: #2B2B29;
            font-size: 20px;
            margin-top: 20px;
        }
        p, li {
            color: #555;
            font-size: 16px;
            margin: 8px 0;
        }
        a {
            color: #F2AF34;
            text-decoration: none;
        }
        .social-icons img {
            margin: 0 5px;
            width: 35px;
            height: 35px;
            transition: all 0.3s;
        }
        .social-icons img:hover {
            opacity: 0.7;
        }

        @media (max-width: 768px) {
            h1 { font-size: 24px; }
            h3, p { font-size: 14px; }
            .content { padding: 15px; }
            .social-icons { text-align: center; margin-top: 10px; }
            .social-icons img { width: 30px; height: 30px; }
            table { background-image: none; background-color: #f7f7f7; }
        }
    </style>
</head>

<body>
<table width="100%" cellpadding="0" cellspacing="0" style="background-image: url(\'' . $BASE_URL . 'API/uploads/email_backgroundd.jpg\'); background-size: cover; padding: 20px; background-position: center;">
<tr>
<td align="center">

<table width="100%" class="content" style="max-width: 600px;">

    <tr>
        <td align="center">
            <img src="' . $BASE_URL . 'admin_panel/images/logo.png" alt="'. htmlspecialchars($APP_NAME) .'" style="width: 100px; margin-bottom: 20px;">
        </td>
    </tr>

    <tr>
        <td>

            <h1>Dear ' . htmlspecialchars($APP_NAME) . ' user – you’ve received a gift 🍕🎉</h1>

            <p>Hello ' . htmlspecialchars($name) . ',</p>

            <p>
                We have a small surprise for you today! 🎉<br>
                As a thank you for your loyalty, we’ve gifted you <strong>' . htmlspecialchars($points) . ' ' . htmlspecialchars($APP_NAME) . ' Coins</strong> – no conditions attached. 💛<br>
                👉 Use your coins on your next order and save instantly at checkout.
            </p>

            <h3>But hurry up ⏳</h3>
            <ul>
                <li>This offer is available for a limited time only. Don’t miss your chance to enjoy your favorite food for less!</li>
            </ul>

            <h3>Why wait?</h3>
            <ul>
                <li>Order now and redeem your gift instantly 🍕🍔</li>
            </ul>

            <p>👀 <a href="' . $BASE_URL . '">Order now</a> and explore your favorites</p>

            <p>We look forward to serving you again!</p>

            <h4>Stay connected with us:</h4>

            <p>Don’t miss any offers or updates – follow us on social media!</p>

            <div class="social-icons">
                <a href="' . htmlspecialchars($FACEBOOK_URL) . '" target="_blank">
                    <img src="https://foodola.foodola.shop/API/uploads/facebook_logo.png" alt="Facebook">
                </a>
                <a href="' . htmlspecialchars($INSTAGRAM_URL) . '" target="_blank">
                    <img src="https://foodola.foodola.shop/API/uploads/instagram_logo.png" alt="Instagram">
                </a>
                <a href="' . htmlspecialchars($TWITTER_URL) . '" target="_blank">
                    <img src="https://foodola.foodola.shop/API/uploads/twitter_logo.png" alt="Twitter">
                </a>
            </div>

            <p>
                Enjoy your meal & have fun!<br>
                <strong>Your ' . htmlspecialchars($APP_NAME) . ' Team 🍕</strong>
            </p>

        </td>
    </tr>

</table>

</td>
</tr>
</table>
</body>
</html>
';

    }
}

function otpEmailTemplate($APP_NAME, $BASE_URL, $token,$LANG = 'en'){

  if ($LANG == 'de') {

        return '
 <html>
    <head>
        <title>Ihr OTP für ' . htmlspecialchars($APP_NAME) . '</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
        <style>
            body {
                font-family: "Poppins", Arial, sans-serif;
                line-height: 1.6;
                color: #333;
                padding: 20px;
                background-color: #f7f7f7;
            }
            .content {
                background-color: rgba(255, 255, 255, 0.95);
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            }
            h1 {
                color: #2B2B29;
                font-size: 28px;
                margin-bottom: 10px;
            }
            h3 {
                color: #2B2B29;
                font-size: 20px;
                margin-top: 20px;
            }
            p, li {
                color: #555;
                font-size: 16px;
                margin: 8px 0;
            }
            a {
                color: #F2AF34;
                text-decoration: none;
            }
            .social-icons img {
                margin: 0 10px;
                width: 35px;
                height: 35px;
                transition: all 0.3s;
            }
            .social-icons img:hover {
                opacity: 0.7;
            }
        </style>
    </head>
    <body>
        <table width="100%" cellpadding="0" cellspacing="0" style="background-image: url(\'' . $BASE_URL . 'API/uploads/email_backgroundd.jpg\'); background-size: cover; padding: 20px; background-position: center;">
            <tr>
                <td align="center">
                    <table width="100%" class="content" style="max-width: 600px;">
                        <tr>
                            <td align="center">
                                <img src="' . $BASE_URL . 'admin_panel/images/logo.png" alt="'. htmlspecialchars($APP_NAME) .'" style="width: 100px; margin-bottom: 20px;">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Ihr Einmalpasswort (OTP) für den Zugriff auf Ihr Konto lautet:</p>
                                <h2>' . htmlspecialchars($token) . '</h2>
                                <p>Bitte verwenden Sie dieses OTP, um Ihre Registrierung abzuschließen.</p>
                                <p>Wenn Sie diese Anfrage nicht gestellt haben, ignorieren Sie bitte diese E-Mail.</p>

                                <p>Mit freundlichen Grüßen,<br>Das Team von ' . htmlspecialchars($APP_NAME) . '</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>
            ';

    } else {
        return '

<html>
  <head>
    <title>Your OTP for ' . htmlspecialchars($APP_NAME) . '</title>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
      integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap"
      rel="stylesheet"
    />
    <style>
      body {
        font-family: "Poppins", Arial, sans-serif;
        line-height: 1.6;
        color: #333;
        padding: 20px;
        background-color: #f7f7f7;
      }
      .content {
        background-color: rgba(255, 255, 255, 0.95);
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      }
      h1 {
        color: #2b2b29;
        font-size: 28px;
        margin-bottom: 10px;
      }
      h3 {
        color: #2b2b29;
        font-size: 20px;
        margin-top: 20px;
      }
      p,
      li {
        color: #555;
        font-size: 16px;
        margin: 8px 0;
      }
      a {
        color: #f2af34;
        text-decoration: none;
      }
      .social-icons img {
        margin: 0 10px;
        width: 35px;
        height: 35px;
        transition: all 0.3s;
      }
      .social-icons img:hover {
        opacity: 0.7;
      }
    </style>
  </head>
  <body>
    <table
      width="100%"
      cellpadding="0"
      cellspacing="0"
      style="
        background-image: url(\'' . $BASE_URL . 'API/uploads/email_backgroundd.jpg\');
        background-size: cover;
        padding: 20px;
        background-position: center;
      "
    >
      <tr>
        <td align="center">
          <table width="100%" class="content" style="max-width: 600px">
            <tr>
              <td align="center">
                <img
                  src="' . $BASE_URL . 'admin_panel/images/logo.png"
                  alt="'. htmlspecialchars($APP_NAME) .'"
                  style="width: 100px; margin-bottom: 20px"
                />
              </td>
            </tr>
            <tr>
              <td>
                <p>
                  Your One-Time Password (OTP) for accessing your account is:
                </p>
                <h2>' . htmlspecialchars($token) . '</h2>
                <p>Please use this OTP to complete your registration.</p>
                <p>If you did not request this, please ignore this email.</p>
                <p>
                  Best regards,<br />The ' . htmlspecialchars($APP_NAME) . '
                  Team
                </p>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </body>
</html>


';

    }
    
}


function orderCancelledEmailTemplate($APP_NAME, $name, $order_id, $BASE_URL, $LANG = 'en') {

    if ($LANG == 'de') {

        return '

<html>
<head>
    <title>Ihre Bestellung wurde storniert – ' . htmlspecialchars($APP_NAME) . '</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: "Poppins", Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            padding: 20px;
            background-color: #f7f7f7;
        }
        .content {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #2B2B29;
            font-size: 28px;
            margin-bottom: 10px;
        }
        h3 {
            color: #2B2B29;
            font-size: 20px;
            margin-top: 20px;
        }
        p, li {
            color: #555;
            font-size: 16px;
            margin: 8px 0;
        }
        a {
            color: #F2AF34;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <table width="100%" cellpadding="0" cellspacing="0" style="background-image: url(\'' . $BASE_URL . 'API/uploads/email_backgroundd.jpg\'); background-size: cover; padding: 20px; background-position: center;">
        <tr>
            <td align="center">
                <table width="100%" class="content" style="max-width: 600px;">

                    <!-- Logo -->
                    <tr>
                        <td align="center">
                            <img src="' . $BASE_URL . 'admin_panel/images/logo.png" alt="' . htmlspecialchars($APP_NAME) . '" style="width: 100px; margin-bottom: 20px;">
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td>
                            <h1>Ihre Bestellung wurde storniert</h1>

                            <p>Hallo <strong>' . htmlspecialchars($name) . '</strong>,</p>

                            <p>
                                Ihre Bestellung <strong>#' . htmlspecialchars($order_id) . '</strong>
                                wurde erfolgreich storniert.
                            </p>

                            <p>
                                Falls bereits eine Zahlung erfolgt ist, wird die Rückerstattung
                                gemäß unseren Richtlinien bearbeitet.
                            </p>

                            <h3>Haben Sie Fragen?</h3>

                            <p>
                                Unser Support-Team steht Ihnen jederzeit zur Verfügung,
                                um Ihre Fragen zu beantworten oder Ihnen bei einer neuen
                                Bestellung zu helfen.
                            </p>

                            <p>
                                Wir hoffen, Sie bald wieder bei
                                <strong>' . htmlspecialchars($APP_NAME) . '</strong>
                                begrüßen zu dürfen.
                            </p>

                            <p>
                                Mit freundlichen Grüßen,<br>
                                Ihr ' . htmlspecialchars($APP_NAME) . ' Team
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>

';

    } else {

        return '

<html>
<head>
    <title>Your Order Has Been Cancelled – ' . htmlspecialchars($APP_NAME) . '</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: "Poppins", Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            padding: 20px;
            background-color: #f7f7f7;
        }
        .content {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #2B2B29;
            font-size: 28px;
            margin-bottom: 10px;
        }
        h3 {
            color: #2B2B29;
            font-size: 20px;
            margin-top: 20px;
        }
        p, li {
            color: #555;
            font-size: 16px;
            margin: 8px 0;
        }
        a {
            color: #F2AF34;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <table width="100%" cellpadding="0" cellspacing="0" style="background-image: url(\'' . $BASE_URL . 'API/uploads/email_backgroundd.jpg\'); background-size: cover; padding: 20px; background-position: center;">
        <tr>
            <td align="center">
                <table width="100%" class="content" style="max-width: 600px;">

                    <!-- Logo -->
                    <tr>
                        <td align="center">
                            <img src="' . $BASE_URL . 'admin_panel/images/logo.png" alt="' . htmlspecialchars($APP_NAME) . '" style="width: 100px; margin-bottom: 20px;">
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td>
                            <h1>Your Order Has Been Cancelled</h1>

                            <p>Hello <strong>' . htmlspecialchars($name) . '</strong>,</p>

                            <p>
                                Your order <strong>#' . htmlspecialchars($order_id) . '</strong>
                                has been successfully cancelled.
                            </p>

                            <p>
                                If a payment has already been made, the refund will be
                                processed according to our policy.
                            </p>

                            <h3>Need Help?</h3>

                            <p>
                                Our support team is always available to answer your
                                questions or assist you with a new order.
                            </p>

                            <p>
                                We hope to serve you again soon at
                                <strong>' . htmlspecialchars($APP_NAME) . '</strong>.
                            </p>

                            <p>
                                Best regards,<br>
                                Your ' . htmlspecialchars($APP_NAME) . ' Team
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>

';

    }
}

?>
  