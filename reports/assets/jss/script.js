 // ── Toggle login / register ──
      const container = document.getElementById("mainContainer");
      const registerBtn = document.querySelector(".register-btn");
      const loginBtn = document.querySelector(".login-btn");

      registerBtn.addEventListener("click", () =>
        container.classList.add("active"),
      );
      loginBtn.addEventListener("click", () =>
        container.classList.remove("active"),
      );

      // ── Switch login type ──
      let currentType = "user";

      function setLoginType(type) {
        currentType = type;

        // Update selector buttons
        document
          .getElementById("btn-user")
          .classList.toggle("active", type === "user");
        document
          .getElementById("btn-other")
          .classList.toggle("active", type === "other");

        // Update badge text
        const labels = {
          user: { login: "User Login", register: "User Registration" },
          other: { login: "Other Login", register: "Other Registration" },
        };
        document.getElementById("loginBadge").textContent = labels[type].login;
        document.getElementById("registerBadge").textContent =
          labels[type].register;

        // Visual pulse on the container
        container.style.boxShadow =
          type === "other"
            ? "0 0 30px rgba(116,148,236,0.45)"
            : "0 0 30px rgba(0,0,0,0.2)";
      }