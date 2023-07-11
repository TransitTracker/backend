const m3 = require("tailwind-m3-colors");

module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      backgroundImage: {
        "tt-pattern": `url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' width='260' height='260'%3E%3Cg fill='%23006b60' fill-opacity='.2'%3E%3Cpath d='M15 23.17h-30v-12.5h30m-3.75 27.5a3.745 3.745 0 01-3.75-3.75 3.745 3.745 0 013.75-3.75A3.745 3.745 0 0115 34.42a3.745 3.745 0 01-3.75 3.75m-22.5 0A3.745 3.745 0 01-15 34.42a3.745 3.745 0 013.75-3.75 3.745 3.745 0 013.75 3.75 3.745 3.745 0 01-3.75 3.75m-8.75-2.5c0 2.2.975 4.174 2.5 5.55v4.45c0 1.374 1.125 2.5 2.5 2.5h2.5c1.375 0 2.5-1.126 2.5-2.5v-2.5h20v2.5c0 1.374 1.125 2.5 2.5 2.5H15c1.375 0 2.5-1.126 2.5-2.5v-4.45c1.525-1.376 2.5-3.35 2.5-5.55v-25c0-8.75-8.95-10-20-10s-20 1.25-20 10zM275 23.17h-30v-12.5h30m-3.75 27.5a3.745 3.745 0 01-3.75-3.75 3.745 3.745 0 013.75-3.75 3.745 3.745 0 013.75 3.75 3.745 3.745 0 01-3.75 3.75m-22.5 0a3.745 3.745 0 01-3.75-3.75 3.745 3.745 0 013.75-3.75 3.745 3.745 0 013.75 3.75 3.745 3.745 0 01-3.75 3.75m-8.75-2.5c0 2.2.975 4.174 2.5 5.55v4.45c0 1.374 1.125 2.5 2.5 2.5h2.5c1.375 0 2.5-1.126 2.5-2.5v-2.5h20v2.5c0 1.374 1.125 2.5 2.5 2.5h2.5c1.375 0 2.5-1.126 2.5-2.5v-4.45c1.525-1.376 2.5-3.35 2.5-5.55v-25c0-8.75-8.95-10-20-10s-20 1.25-20 10zM32.04 79.55L23.44 86l5.375 4.3H23.44s-6.45 0-6.45 6.45v21.5h10.75s0-4.3 4.3-4.3h27.95v-6.45h-8.6V94.6h8.6v-4.3H35.265L40.64 86l-8.6-6.45M21.29 94.6h10.75v12.9H21.29V94.6m15.05 0h10.75v12.9H36.34V94.6m-15.05 17.2h2.15v4.3h-2.15v-4.3m10.75 6.45v1.075a5.377 5.377 0 005.375 5.375 5.367 5.367 0 004.924-3.225h3.053a5.367 5.367 0 004.923 3.225 5.377 5.377 0 005.375-5.375v-1.075zM201.57 104a2 2 0 012 2 2 2 0 01-2 2 2 2 0 01-2-2 2 2 0 012-2m-3-12h20v10h-20V92m17 12a2 2 0 012 2 2 2 0 01-2 2 2 2 0 01-2-2 2 2 0 012-2m5 1.76V92c0-5.24-5.36-6-12-6-6 0-12 .74-12 6v13.76a5.24 5.24 0 005.24 5.24l-2.24 2.24v.76h3.34l3-3h5.66l3 3h3v-.76l-2.26-2.24c2.9 0 5.26-2.34 5.26-5.24m-.4-26.16c5.34 2.08 8.4 6.5 8.4 12.12V118h-40V91.72c0-5.62 3.06-10.04 8.4-12.12 3.6-1.42 7.88-1.6 11.6-1.6 3.72 0 8 .18 11.6 1.6zM75.83 205.12h2.625v4.935l4.27 2.467-1.313 2.276-5.582-3.22v-6.458m-17.5-17.5h24.5a3.51 3.51 0 013.5 3.5v10.675a12.177 12.177 0 013.5 8.575c0 6.772-5.478 12.25-12.25 12.25-3.342 0-6.37-1.33-8.575-3.5H58.33a3.51 3.51 0 01-3.5-3.5v-24.5a3.51 3.51 0 013.5-3.5m0 22.75v5.25h8.172a12.273 12.273 0 01-1.172-5.25h-7m0-12.25h10.5v-5.25h-10.5v5.25m24.5 0v-5.25h-10.5v5.25h10.5m-24.5 8.75h7.507a12.16 12.16 0 013.168-5.25H58.33v5.25m19.25-4.988a8.484 8.484 0 00-8.488 8.488 8.484 8.484 0 008.488 8.488 8.484 8.484 0 008.488-8.488 8.484 8.484 0 00-8.488-8.488zM134 123.17a5.558 5.558 0 005.556-5.556A5.558 5.558 0 00134 112.06a5.558 5.558 0 00-5.556 5.555A5.558 5.558 0 00134 123.17m0-21.111c8.578 0 15.556 6.955 15.556 15.555 0 11.667-15.556 28.89-15.556 28.89s-15.556-17.223-15.556-28.89c0-8.6 6.956-15.555 15.556-15.555m-20 15.555c0 10 11.289 23.69 13.333 26.245l-2.222 2.644s-15.555-17.222-15.555-28.889c0-7.044 4.688-13 11.11-14.91-4.088 3.666-6.666 8.977-6.666 14.91zM119.5 16.75h21v6.93L130 20.25l-10.5 3.43m-3.605 15.82H116c2.8 0 5.25-1.54 7-3.5 1.75 1.96 4.2 3.5 7 3.5s5.25-1.54 7-3.5c1.75 1.96 4.2 3.5 7 3.5h.087l3.326-11.707c.14-.438.087-.928-.106-1.348a1.794 1.794 0 00-1.05-.875L144 24.835V16.75c0-1.942-1.575-3.5-3.5-3.5h-5.25V8h-10.5v5.25h-5.25a3.5 3.5 0 00-3.5 3.5v8.085l-2.257.735c-.455.14-.823.455-1.05.875-.193.42-.245.91-.105 1.347M144 43c-2.433 0-4.865-.823-7-2.328-4.27 2.993-9.73 2.993-14 0-2.135 1.506-4.567 2.328-7 2.328h-3.5v3.5h3.5c2.397 0 4.795-.613 7-1.75a15.212 15.212 0 0014 0c2.205 1.137 4.585 1.75 7 1.75h3.5V43zM168.714 232.4v-24.114c0-7.972-7.457-9.715-17.143-10l2.143-4.286H163v-4.286h-28.571V194H148l-2.143 4.286c-8.971.314-17.143 2.085-17.143 10V232.4c0 4.143 3.4 7.6 7.4 8.486l-4.543 4.543v1.428h6.372l5.714-5.714h10.772l5.714 5.714h5.714v-1.428l-4.286-4.286h-.228c4.828 0 7.371-3.914 7.371-8.743m-20 4.457a4.286 4.286 0 01-4.285-4.286 4.286 4.286 0 014.285-4.285A4.286 4.286 0 01153 232.57a4.286 4.286 0 01-4.286 4.286M163 224h-28.571v-14.286H163zM-7.25 170c-12.5 0-25 1.563-25 12.5v29.688c0 6.03 4.906 10.937 10.938 10.937L-26 227.813v1.562h6.969l6.25-6.25H-1l6.25 6.25h6.25v-1.563l-4.688-4.687c6.032 0 10.938-4.906 10.938-10.938V182.5c0-10.938-11.188-12.5-25-12.5m-14.063 46.875A4.681 4.681 0 01-26 212.187a4.681 4.681 0 014.688-4.687 4.681 4.681 0 014.687 4.688 4.681 4.681 0 01-4.688 4.687M-10.374 195H-26v-12.5h15.625V195m6.25 0v-12.5H11.5V195H-4.125m10.938 21.875a4.681 4.681 0 01-4.688-4.688 4.681 4.681 0 014.688-4.687 4.681 4.681 0 014.687 4.688 4.681 4.681 0 01-4.688 4.687zM252.75 170c-12.5 0-25 1.563-25 12.5v29.688c0 6.03 4.906 10.937 10.938 10.937L234 227.813v1.562h6.969l6.25-6.25H259l6.25 6.25h6.25v-1.563l-4.688-4.687c6.032 0 10.938-4.906 10.938-10.938V182.5c0-10.938-11.188-12.5-25-12.5m-14.063 46.875a4.681 4.681 0 01-4.687-4.688 4.681 4.681 0 014.688-4.687 4.681 4.681 0 014.687 4.688 4.681 4.681 0 01-4.688 4.687M249.625 195H234v-12.5h15.625V195m6.25 0v-12.5H271.5V195h-15.625m10.938 21.875a4.681 4.681 0 01-4.688-4.688 4.681 4.681 0 014.688-4.687 4.681 4.681 0 014.687 4.688 4.681 4.681 0 01-4.688 4.687z'/%3E%3C/g%3E%3C/svg%3E")`,
      },
      backgroundSize: {
        32: "8rem",
      },
      boxShadow: {
        2: '0px 1px 2px rgba(0, 0, 0, 0.3), 0px 2px 6px 2px rgba(0, 0, 0, 0.15)',
        3: '0px 4px 8px 3px rgba(0, 0, 0, 0.15), 0px 1px 3px rgba(0, 0, 0, 0.3)',
      },
    },
    fontFamily: {
      heading: ["Figtree", "sans-serif"],
      sans: ["Inter", "sans-serif"],
    },
  },
  plugins: [
    require("@tailwindcss/forms"),
    require("@tailwindcss/typography"),
    m3("#2374ab", "#009a8d", "", {
      stepTonesBy10: true,
      inverseSteps: false,
    }),
  ],
};
