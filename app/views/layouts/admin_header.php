<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Zentro Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@400;700;800;900&amp;family=Be+Vietnam+Pro:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            colors: {
              "tertiary-container": "#5e605c",
              "primary": "#384e21",
              "error-container": "#ffdad6",
              "outline-variant": "#c5c8ba",
              "surface-variant": "#e1e3dc",
              "error": "#ba1a1a",
              "outline": "#75796d",
              "inverse-primary": "#b5cf95",
              "surface": "#f9faf2",
              "tertiary-fixed-dim": "#c6c7c2",
              "surface-container-lowest": "#ffffff",
              "primary-fixed-dim": "#b5cf95",
              "surface-bright": "#f9faf2",
              "on-surface": "#191c18",
              "background": "#f9faf2",
              "on-tertiary": "#ffffff",
              "on-secondary": "#ffffff",
              "surface-dim": "#d9dbd3",
              "on-background": "#191c18",
              "on-tertiary-container": "#dadad6",
              "on-error": "#ffffff",
              "on-surface-variant": "#44483e",
              "tertiary-fixed": "#e3e3de",
              "on-secondary-container": "#7a5b3b",
              "inverse-surface": "#2e312c",
              "tertiary": "#474845",
              "surface-container": "#edefe7",
              "on-primary-fixed-variant": "#374d20",
              "inverse-on-surface": "#f0f1ea",
              "on-error-container": "#93000a",
              "secondary-fixed": "#ffdcbd",
              "primary-container": "#4f6636",
              "secondary": "#775839",
              "on-secondary-fixed-variant": "#5d4123",
              "secondary-container": "#ffd5ae",
              "primary-fixed": "#d0ecaf",
              "surface-container-high": "#e7e9e1",
              "surface-tint": "#4e6535",
              "on-primary-container": "#c7e3a7",
              "surface-container-low": "#f3f4ed",
              "on-secondary-fixed": "#2c1701",
              "secondary-fixed-dim": "#e8bf98",
              "on-tertiary-fixed-variant": "#454744",
              "on-primary-fixed": "#0f2000",
              "surface-container-highest": "#e1e3dc",
              "on-primary": "#ffffff",
              "on-tertiary-fixed": "#1a1c19"
            },
            fontFamily: {
              "headline": ["Epilogue"],
              "body": ["Be Vietnam Pro"],
              "label": ["Be Vietnam Pro"]
            },
            borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
          },
        },
      }
    </script>
    <style>
        body { font-family: 'Be Vietnam Pro', sans-serif; }
        .font-headline { font-family: 'Epilogue', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
    </style>
</head>
<body class="bg-surface text-on-surface min-h-screen">