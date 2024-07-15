module.exports = {
  proxy: "https://best-one.local/",
  https: {
    key: "localhost-key.pem",
    cert: "localhost.pem"
  },
  files: ["**/*.php", "*.css", "**/*.css", "**/*.js"],
  notify: false,
  open: false,  // Optional: prevents auto-opening a new browser window
  reloadOnRestart: true  // Optional: ensures the browser reloads on restart
};
