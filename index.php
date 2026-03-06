<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Gallery Website</title>
    <link rel="shortcut icon" type="x-icon" href="Screenshot_20200717_184504.png">

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.11/typed.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <!-- box icons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>


    <!-- css icon assetes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

    <!-- Unicons CDN (ensure solid + line icons) -->
    <link href="https://unicons.iconscout.com/release/v4.0.8/css/line.css" rel="stylesheet">
    <link href="https://unicons.iconscout.com/release/v4.0.8/css/solid.css" rel="stylesheet">

    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">

    <!-- style.css -->
    <link rel="stylesheet" href="./source/CSS/style.css">

    <!-- JavaScript -->
    <script src="./source/JS/script.js" defer></script>

    <!-- script filter  -->
    <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
    <script src="https://unpkg.com/imagesloaded@5/imagesloaded.pkgd.min.js"></script>

  </head>

  <body>
    <!--==================== SCROLL TOP ====================-->
    <a href="#" class="scrollup" id="scroll-up">
      <i class="uil uil-arrow-up scrollup__icon"></i>
    </a>

    <!-- ================================ header design ================================-->
    <header class="header">
      <!-- <div class="logo">
          <img src="./source/img/logo.jfif" alt="logo">    
        </div> -->

      <div class="logo">
        <img src="./source/img/logo.jfif" alt="logo">
        <a href="#">Crime<span>Report</span></a>
      </div>

      <div class="bx bx-menu" id="menu-icon">
      </div>

      <nav class="navbar">
        <a href="#home" class="active"><i class='bx bx-home'></i> Home</a>
        <a href="#about"><i class='bx bx-user'></i> About</a>
        <!-- <a href="#skills"><i class='bx bx-file'></i> Skills</a> -->
        <a href="#services"><i class='bx bxs-briefcase icon'></i> Services</a>
        <!-- <a href="#Gallery"><i class='bx bxs-folder-open icon'></i> Projects</a> -->
        <a href="#portfolio"><i class='bx bxs-award icon'></i> Gallery</a>
        <a href="#team"><i class='bx bxs-group icon'></i> Team</a>
        <a href="#contact"><i class='bx bx-envelope icon'></i> Contact</a>
        <a href="reports/index.php"> <i class='bx bx-log-in icon'></i> login</a>   
        <span class="active-nav"></span>
      </nav>
    </header>
    
    <!-- ================================ home section ================================-->
    <section class="home show-animate" id="home">
      <div class="home-content">
        <h3>Hello, This is</h3>
        <h1>Digitalization of Crime <br><span>Report System</span></h1>
        <!-- <h2> The crim <span class="multiple-text"> </span></h2> -->
        <h2 class="crime-line">The Crim<span class="multiple-text"></span></h2>

        <h2>“Digitizing Crime Reporting for a Safer Tomorrow” ✅</h2>

        <!-- <div class="social-media">
          <a href="https://github.com/syedadils28" class="tooltip" target="_blank">
            <i class='bx bxl-github'></i>
            <span class="tooltip-text">GitHub</span>
          </a>
          <a href="http://www.linkedin.com/in/syed-adil-s28" class="tooltip" target="_blank">
            <i class='bx bxl-linkedin-square'></i>
            <span class="tooltip-text">LinkedIn</span>
          </a>
          <a href="mailto:syedadils20004@gmail.com" class="tooltip" target="_blank">
            <i class='bx bxs-envelope'></i>
            <span class="tooltip-text">Email</span>
          </a>
          <a href="https://www.instagram.com/" class="tooltip" target="_blank">
              <i class='bx bxl-instagram' ></i>
              <span class="tooltip-text">Instagram</span>
            </a>
        </div> -->
        <a href="source/pdf/efir.pdf" class="btn" download> E-Crime Era <i class='bx bx-download'></i> </a>
      </div>

      <!-- <div class="home-img">
          <img src="assets/img/syedadilsimm.jpg" alt="Profile Image">
        </div>    -->

      <!-- Scroll Down Button -->
      <div class="home__scroll">
        <a href="#about" class="home__scroll-button button--flex">
          <!-- <i class="uil uil-mouse-alt home__scroll-mouse"></i> -->
          <!-- <span class="home__scroll-name">Scroll down</span> -->
          <i class="uil uil-arrow-down home__scroll-arrow"></i>
        </a>
      </div>
    </section>

    <!-- ================================ about section design ================================-->
    <section class="about" id="about">
      <h2 class="heading">About <span>website</span></h2>

      <div class="about-row">
        <div class="about-img">
          <img src="./source/img/about/about.jfif" alt="">
        </div>

        <div class="about-content">
          <!-- <h3>Frontend Developer !</h3> -->
          <div class="text"> About <span class="adname">and</span> Aim <span class="typing-2"></span></div>
          <p>
            &nbsp;&nbsp;&nbsp;&nbsp;This Crime Reporting System allows users to anonymously or securely report incidents
            to authorities.
            Our platform ensures privacy, quick response, and community safety. Report theft, assault, vandalism, or other
            crimes with ease.<br><br>

            &nbsp;&nbsp;&nbsp;&nbsp;Our aim is to empower communities by providing a safe, accessible platform for crime
            reporting.
            We strive to reduce crime rates through timely interventions, data-driven insights, and collaboration with law
            enforcement. Together,
            we build safer neighborhoods. <br>
            <!-- Proficient in Microsoft Office, specializing in MS Word, MS Excel, and MS PowerPoint, with a proven ability to reduce office task 
              completion time by 20%. <br>-->
          </p>

          <!-- <div class="btn-box btns">
            <a href="#" class="btn">Read More</a>
          </div> -->
        </div>
    </section>

    <!-- ================================ services section design  ================================-->
    <section class="services" id="services">
      <h2 class="heading">My <span>Services</span></h2>

      <div class="services-container">
        <div class="services-box">
          <i class='bx bx-code-alt'></i>
          <h3>COMPLAINT FIR</h3>
          <p>
            Easily file a First Information Report (FIR) through our secure digital portal.
            We provide a streamlined process to document incidents, attach evidence, and
            notify the relevant authorities instantly.
          </p>
        </div>

        <div class="services-box">
          <i class='bx bx-desktop'></i>
          <h3>VIEW DAILY NEWS</h3>
          <p>
            Stay informed with real-time updates on local safety, crime trends, and public advisories.
            Our news feed pulls verified data from law enforcement agencies to keep your community safe.
          </p>
        </div>

        <div class="services-box">
          <i class='bx bx-desktop'></i>
          <h3>VIEW FIR STATUS</h3>
          <p>
            Track the progress of your filed complaints in real-time.
            Enter your reference number to see investigation updates, officer assignments,
            and the current legal standing of your case.
          </p>
        </div>

        <!-- <div class="services-box">
            <i class='bx bx-palette'></i>
            <h3>UI Development</h3>
            <p>
            UI (User Interface) development focuses on 
            creating the visual elements of a website or 
            application. I specialize in turning design 
            mockups into interactive interfaces using HTML, CSS, 
            and JavaScript.
            </p>
          </div> -->

      </div>
    </section>

    <!-- ================================ Gallery ================================-->

    <section id="portfolio" class="portfolio section light-background">
      <h2 class="heading">My <span>Gallary</span></h2>
      <!-- <div class="container section-title" data-aos="fade-up">
          <h2>Portfolio</h2>
          <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. 
            Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
        </div> -->

      <div class="container">
        <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">
          <ul class="portfolio-filters isotope-filters" data-aos="fade-up" data-aos-delay="100">
            <li data-filter="*" class="filter-active">All</li>
            <li data-filter=".filter-Cyber">Cyber Crimes</li>
            <li data-filter=".filter-property">Property Crimes</li>
            <li data-filter=".filter-Violent">Violent Crimes</li>
            <li data-filter=".filter-Organized">Organized Crimes</li>
          </ul><!-- End Portfolio Filters -->

          <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">

            <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-Organized">
              <div class="portfolio-content h-100">
                <img src="./source/img/gallary/organi/drug.jpg" class="img-fluid" alt="Book 1">
                <div class="portfolio-info">
                  <h4>Drug Trafficking</h4>
                  <p>Illegal trade of controlled substances across borders or within a country.</p>
                  <a href="./source/img/gallary/organi/drug.jpg" title="Drug Trafficking" data-gallery="portfolio-gallery-book"
                    class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                  <a href="portfolio-details.html" title="More Details" class="details-link"><i
                      class="bi bi-link-45deg"></i></a>
                </div>
              </div>
            </div>

            <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-Cyber">
              <div class="portfolio-wrap">
                <div class="portfolio-content">
                  <img src="./source/img/gallary/cyber/Cyber1.jfif" class="img-fluid" alt="App 1">
                  <div class="portfolio-info">
                    <h4>Hacking</h4>
                    <p>Unauthorized access to someone’s computer, system, or account.</p>
                    <a href="./source/img/gallary/cyber/Cyber1.jfif" data-gallery="portfolio-gallery-app"
                      class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                    <a href="portfolio-details.html" class="details-link"><i class="bi bi-link-45deg"></i></a>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-Cyber">
              <div class="portfolio-content h-100">
                <img src="./source/img/gallary/cyber/Cyberbullying.jpeg" class="img-fluid" alt="">
                <div class="portfolio-info">
                  <h4>Cyberbullying</h4>
                  <p>Harassing or threatening someone online through social media or messages.</p>
                  <a href="./source/img/gallary/cyber/Cyberbullying.jpeg" title="Cyberbullying" data-gallery="portfolio-gallery-cyber"
                    class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                  <a href="portfolio-details.html" title="More Details" class="details-link"><i
                      class="bi bi-link-45deg"></i></a>
                </div>
              </div>
            </div>

            <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-property">
              <div class="portfolio-content h-100">
                <img src="./source/img/gallary/property/theft.jpg" class="img-fluid" alt="">
                <div class="portfolio-info">
                  <h4>Theft</h4>
                  <p>Unauthorized taking of someone's property.</p>
                  <a href="./source/img/gallary/property/theft.jpg" title="Theft" data-gallery="portfolio-gallery-product"
                    class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                  <a href="portfolio-details.html" title="More Details" class="details-link"><i
                      class="bi bi-link-45deg"></i></a>
                </div>
              </div>
            </div>

            <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-Violent">
              <div class="portfolio-content h-100">
                <img src="./source/img/gallary/srial/sec1.jpg" class="img-fluid" alt="">
                <div class="portfolio-info">
                  <h4>criminal record</h4>
                  <p>Official documentation of a person's criminal history.</p>
                  <a href="./source/img/gallary/srial/sec1.jpg" title="Criminal Record" data-gallery="portfolio-gallery-branding"
                    class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                  <a href="portfolio-details.html" title="More Details" class="details-link"><i
                      class="bi bi-link-45deg"></i></a>
                </div>
              </div>
            </div>

            <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-Organized">
              <div class="portfolio-content h-100">
                <img src="./source/img/gallary/organi/child.jpg" class="img-fluid" alt="">
                <div class="portfolio-info">
                  <h4>Human Trafficking</h4>
                  <p>Illegal buying, selling, or exploitation of people for labor or prostitution.</p>
                  <a href="./source/img/gallary/organi/child.jpg" title="Human Trafficking" data-gallery="portfolio-gallery-book"
                    class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                  <a href="portfolio-details.html" title="More Details" class="details-link"><i
                      class="bi bi-link-45deg"></i></a>
                </div>
              </div>
            </div>

            <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-Cyber">
              <div class="portfolio-content h-100">
                <img src="./source/img/gallary/cyber/identity.jpg" class="img-fluid" alt="">
                <div class="portfolio-info">
                  <h4>Identity Theft</h4>
                  <p>Stealing someone's personal information (Aadhaar, bank details, passwords) to commit fraud or other crimes.</p>
                  <a href="./source/img/gallary/cyber/identity.jpg" title="Identity Theft" data-gallery="portfolio-gallery-cyber"
                    class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                  <a href="portfolio-details.html" title="More Details" class="details-link"><i
                      class="bi bi-link-45deg"></i></a>
                </div>
              </div>
            </div>

            <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-property">
              <div class="portfolio-content h-100">
                <img src="./source/img/gallary/property/robbery.jpg" class="img-fluid" alt="">
                <div class="portfolio-info">
                  <h4>Robbery</h4>
                  <p>Unauthorized taking of someone's property in a public place.</p>
                  <a href="./source/img/gallary/property/robbery.jpg" title="Robbery" data-gallery="portfolio-gallery-product"
                    class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                  <a href="portfolio-details.html" title="More Details" class="details-link"><i
                      class="bi bi-link-45deg"></i></a>
                </div>
              </div>
            </div>

            <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-Violent">
              <div class="portfolio-content h-100">
                <img src="./source/img/gallary/srial/scri2.jpg" class="img-fluid" alt="">
                <div class="portfolio-info">
                  <h4>Serial Crime</h4>
                  <p>Repeated criminal behavior over time, often involving a pattern of similar crimes.</p>
                  <a href="./source/img/gallary/srial/sec2.jpg" title="Serial Crime" data-gallery="portfolio-gallery-branding"
                    class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                  <a href="portfolio-details.html" title="More Details" class="details-link"><i
                      class="bi bi-link-45deg"></i></a>
                </div>
              </div>
            </div>

            <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-Organized">
              <div class="portfolio-content h-100">
                <img src="./source/img/gallary/organi/arms.jpg" class="img-fluid" alt="">
                <div class="portfolio-info">
                  <h4>Arms Trafficking</h4>
                  <p>Illegal trade of weapons, ammunition, or other military equipment.</p>
                  <a href="./source/img/gallary/organi/arms.jpg" title="Arms Trafficking" data-gallery="portfolio-gallery-book"
                    class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                  <a href="portfolio-details.html" title="More Details" class="details-link"><i
                      class="bi bi-link-45deg"></i></a>
                </div>
              </div>
            </div>

            <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-Cyber">
              <div class="portfolio-content h-100">
                <img src="./source/img/gallary/cyber/payment1.jpg" class="img-fluid" alt="">
                <div class="portfolio-info">
                  <h4>Online Fraud</h4>
                  <p>Cheating people through fake websites, fake calls, or online scams.</p>
                  <a href="./source/img/gallary/cyber/payment1.jpg" title="Online Fraud" data-gallery="portfolio-gallery-cyber"
                    class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                  <a href="portfolio-details.html" title="More Details" class="details-link"><i
                      class="bi bi-link-45deg"></i></a>
                </div>
              </div>
            </div>

            <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-property">
              <div class="portfolio-content h-100">
                <img src="./source/img/gallary/property/Burglar.jpg" class="img-fluid" alt="">
                <div class="portfolio-info">
                  <h4>Burglary</h4>
                  <p>Entering a house or building illegally to commit a crime (usually theft)</p>
                  <a href="./source/img/gallary/property/Burglar.jpg" title="Burglary" data-gallery="portfolio-gallery-product"
                    class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                  <a href="portfolio-details.html" title="More Details" class="details-link"><i
                      class="bi bi-link-45deg"></i></a>
                </div>
              </div>
            </div>

            <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-Violent">
              <div class="portfolio-content h-100">
                <img src="./source/img/gallary/srial/scrial1.jfif" class="img-fluid" alt="">
                <div class="portfolio-info">
                  <h4>Violent Crime</h4>
                  <p>Crimes involving physical force or threat of force against another person.</p>
                  <a href="./source/img/gallary/srial/scrial1.jfif" title="Violent Crime" data-gallery="portfolio-gallery-branding"
                    class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                  <a href="portfolio-details.html" title="More Details" class="details-link"><i
                      class="bi bi-link-45deg"></i></a>
                </div>
              </div>
            </div>

            <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-Organized">
              <div class="portfolio-content h-100">
                <img src="./source/img/gallary/organi/orga.jfif" class="img-fluid" alt="">
                <div class="portfolio-info">
                  <h4>Organized Crime</h4>
                  <p>Coordinated criminal activity involving multiple individuals or groups.</p>
                  <a href="./source/img/gallary/organi/orga.jfif" title="Organized Crime" data-gallery="portfolio-gallery-book"
                    class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                  <a href="portfolio-details.html" title="More Details" class="details-link"><i
                      class="bi bi-link-45deg"></i></a>
                </div>
              </div>
            </div>

          </div><!-- End Portfolio Container -->

        </div>

      </div>

    </section>

    <!-- ================================ team members  ================================-->

    <section class="team" id="team">
      <h2 class="heading">Our <span>Team</span></h2>

      <div class="team-container">
        <div class="team-box">
          <img src="path/to/syed-sameer-photo.jpg" alt="Syed Sameer S">
          <h3>Syed Sameer S</h3>
          <p>
            Syed Sameer S is a skilled web developer with expertise in front-end technologies.
            He specializes in creating responsive and user-friendly websites, bringing innovative ideas to life through
            code.
          </p>
        </div>

        <div class="team-box">
          <img src="path/to/khazi-abdul-athif-photo.jpg" alt="Khazi Abdul Athif">
          <h3>Khazi Abdul Athif</h3>
          <p>
            Khazi Abdul Athif is a talented UI/UX designer proficient in tools like Figma and CorelDRAW.
            He designs modern interfaces and branding solutions, transforming concepts into interactive digital
            experiences.
          </p>
        </div>

        <div class="team-box">
          <img src="path/to/umar-farooq-photo.jpg" alt="Umar Farooq">
          <h3>Umar Farooq</h3>
          <p>
            Umar Farooq is a versatile developer focused on full-stack solutions.
            He excels in building dynamic web applications and ensuring seamless user experiences across platforms.
          </p>
        </div>
      </div>
    </section>

    <!-- ================================ contact section design  ================================-->
    <section class="contact" id="contact">
      <h2 class="heading">Contact <span>Me!</span></h2>

      <form action="" method="post" name="google-sheet">
        <div class="input-box">
          <div class="input-field">
            <input type="text" name="Full Name" placeholder="Full Name" required>
            <span class="focus"></span>
          </div>
          <div class="input-field">
            <input type="email" name="Email Address" placeholder="Email Address" required>
            <span class="focus"></span>
          </div>
        </div>

        <div class="input-box">
          <!-- <div class="input-field">
              <input type="number" placeholder="Mobile Number" required>
              <span class="focus"></span>
            </div> -->
          <div class="input-field">
            <input type="text" name="Subject" placeholder="Subject" required>
            <span class="focus"></span>
          </div>
        </div>

        <div class="textarea-field">
          <textarea name="Your Message" id="Your Message" cols="30" rows="10" placeholder="Your Message"
            required></textarea>
          <span class="focus"></span>
        </div>

        <div class="btn-box btns">
          <button type="submit" name="submit" class="btn">Submit</button>
        </div>
      </form>
    </section>

    <!-- ================================ Footer section design  ================================-->
    <footer class="footer">
      <div class="footer-content">
        <!-- Left -->
        <div class="footer-left">
          <p>Copyright &copy; 2026 by <span class="footer-span">crime report</span> | All Rights Reserved.</p>
        </div>

        <!-- Center -->
        <!-- <div class="footer-center">
          <p>Need a Portfolio Website Like This | Let's Connect</p> -->


          <!-- <a href="https://github.com/syedadils28" target="_blank">
            <i class='bx bxl-github'></i>
          </a>
          <a href="http://www.linkedin.com/in/syed-adil-s28" target="_blank">
            <i class='bx bxl-linkedin'></i>
          </a> -->
          <!-- <a href="https://www.instagram.com/thakur.sa.abhay/" target="_blank">
              <i class='bx bxl-instagram'></i>
            </a> -->
        </div>
      </div>
    </footer>
    
    <!-- google-sheet -->
    <script>
      const scriptURL = 'https://script.google.com/macros/s/AKfycbxGz-hi8TAT386G6fntWXKh_a95giZSTQQXiBp6FQ5DeA5U-_5ZE-BL2Fe2Z4HvZne3lA/exec';
      const form = document.forms['google-sheet'];
      // const msg = document.getElementById("msg");

      form.addEventListener('submit', e => {
        e.preventDefault(); // stop page reload
        fetch(scriptURL, { method: 'POST', body: new FormData(form)})
          .then(response => {
            alert("✅ Message Sent Successfully!");
            form.reset(); // clear inputs only after successful submit
          })
          .catch(error => {
            alert("❌ Something went wrong! Please try again.");
            console.error('Error!', error.message);
          })
      })
    </script>
  </body>

</html>