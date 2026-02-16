Ein WordPress-Plugin, mit dem du WPForms-Formulare visuell pro Formular stylen kannst – inklusive Live-Vorschau im Adminbereich.

## Features

- eigenes **Styles-Untermenü** direkt unter WPForms
- Auswahl eines vorhandenen WPForms-Formulars
- visuelle Farbsteuerung für:
  - Card-Hintergrund
  - Card-Rand
  - Input-Hintergrund
  - Input-Rand
  - Input-Text
  - Button-Hintergrund
  - Button-Hover-Hintergrund
- **Live-Preview** über iFrame-Ansicht
- Speicherung der Styles pro Formular in den WordPress-Optionen
- automatische Ausgabe der gespeicherten CSS-Variablen im Frontend

## Voraussetzungen

- WordPress
- [WPForms](https://wpforms.com/) (aktiviert)
- optional: Blocksy Companion (für den eingebundenen Blocksy-Colorpicker)

> Hinweis: Ohne installiertes und aktiviertes WPForms wird im Adminbereich eine Fehlermeldung angezeigt und der Styler nicht genutzt.

## Installation

1. Repository herunterladen oder klonen.
2. Ordner `wpforms-visual-styler` nach `wp-content/plugins/` kopieren.
3. Plugin in WordPress aktivieren.
4. Im Backend zu **WPForms → Styles** navigieren.

## Verwendung

1. Unter **WPForms → Styles** ein Formular aus der linken Liste auswählen.
2. Farben in den Bereichen *Card*, *Inputs* und *Buttons* setzen.
3. Die Vorschau wird live im rechten Bereich aktualisiert.
4. Auf **Speichern** klicken, um die Formulareinstellungen dauerhaft abzulegen.

## Technischer Überblick

- Einstiegspunkt: `wpforms-visual-styler.php`
- Admin-Ansicht: `admin/page.php`
- React-UI: `admin/react-app.js`
- Speichern via AJAX: `admin/ajax.php`
- Vorschau-Endpoint: `public/preview.php`
- Frontend-CSS-Ausgabe: `public/css-output.php`

Die Styles werden formularweise in Optionen wie `wpvs_style_<FORM_ID>` gespeichert.

## Entwicklung

Lokale Änderungen kannst du direkt im Plugin-Verzeichnis vornehmen. Für dieses Repository gibt es derzeit keinen Build-Schritt; die Admin-Logik wird direkt aus `admin/react-app.js` geladen.

## Sicherheitshinweis

Dieses Repository enthält bereits eine Datei `SECURITY_SCAN.md`. Wenn du das Plugin produktiv einsetzen möchtest, empfiehlt sich vor dem Deployment ein erneuter Sicherheits- und Code-Review.

## Lizenz

Siehe Datei [`LICENSE`](LICENSE).
