import type { Config } from "tailwindcss";

const config: Config = {
  content: [
    "./app/**/*.{ts,tsx}",
    "./components/**/*.{ts,tsx}",
    "./lib/**/*.{ts,tsx}"
  ],
  theme: {
    extend: {
      colors: {
        brand: {
          pink: "#e736a9",
          purple: "#542bf7"
        }
      },
      boxShadow: {
        card: "0 0.5rem 1rem rgba(0, 0, 0, 0.15)"
      }
    }
  },
  plugins: []
};

export default config;
