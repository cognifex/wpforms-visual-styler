const { createElement, render, useEffect, useState } = window.wp.element;
const {
    ColorGradientSettingsDropdown,
    useMultipleOriginColorsAndGradients,
} = window.wp.blockEditor || window.wp.editor || {};

function WPVSApp() {
    const [formId, setFormId] = useState(null);
    const [settings, setSettings] = useState({});
    const [isSaving, setIsSaving] = useState(false);
    const [saveMessage, setSaveMessage] = useState("");

    useEffect(() => {
        document.querySelectorAll("#wpvs-form-list li").forEach((li) => {
            li.onclick = () => {
                const id = li.dataset.id;
                const storedSettings = li.dataset.settings
                    ? JSON.parse(li.dataset.settings)
                    : {};

                setFormId(id);
                setSettings(storedSettings || {});
            };
        });
    }, []);

    useEffect(() => {
        if (!formId) return;
        updatePreview();
    }, [formId, settings]);

    const updatePreview = () => {
        const iframe = document.getElementById("wpvs-iframe");
        if (!iframe || !formId) return;

        const params = new URLSearchParams(settings).toString();
        const query = params ? `?${params}` : "";
        iframe.src = `${WPVS.previewBase}${formId}${query}`;
    };

    const BlocksyColor = ({ field }) => {
        if (!ColorGradientSettingsDropdown || !useMultipleOriginColorsAndGradients) {
            return createElement("p", {}, "Der Gutenberg Color Picker konnte nicht geladen werden.");
        }

        const colorSettings = useMultipleOriginColorsAndGradients();
        return createElement(ColorGradientSettingsDropdown, {
            __experimentalIsRenderedInSidebar: true,
            __experimentalHasMultipleOrigins: true,
            settings: [
                {
                    label: field,
                    colorValue: settings[field] || "",
                    onColorChange: (value) => {
                        setSettings((prev) => ({ ...prev, [field]: value || "" }));
                    },
                },
            ],
            ...colorSettings,
        });
    };

    const handleSave = async () => {
        if (!formId) return;

        setIsSaving(true);
        setSaveMessage("");

        try {
            const data = new FormData();
            data.append("action", "wpvs_save");
            data.append("form_id", formId);
            data.append("settings", JSON.stringify(settings));

            await fetch(WPVS.ajax, { method: "POST", body: data });
            setSaveMessage("Gespeichert.");
        } catch (e) {
            setSaveMessage("Fehler beim Speichern.");
        } finally {
            setIsSaving(false);
        }
    };

    if (!formId) return "Bitte Formular links auswählen.";

    return createElement("div", {}, [
        createElement("h3", { key: "heading" }, "Style Einstellungen"),

        createElement("h4", { key: "card" }, "Card"),
        createElement(BlocksyColor, { field: "card_bg", key: "card_bg" }),
        createElement(BlocksyColor, { field: "card_border", key: "card_border" }),

        createElement("h4", { key: "inputs" }, "Inputs"),
        createElement(BlocksyColor, { field: "input_bg", key: "input_bg" }),
        createElement(BlocksyColor, { field: "input_border", key: "input_border" }),
        createElement(BlocksyColor, { field: "input_text", key: "input_text" }),

        createElement("h4", { key: "buttons" }, "Buttons"),
        createElement(BlocksyColor, { field: "btn_bg", key: "btn_bg" }),
        createElement(BlocksyColor, { field: "btn_bg_hov", key: "btn_bg_hov" }),

        createElement(
            "div",
            { key: "actions", style: { marginTop: "12px", display: "flex", gap: "8px", alignItems: "center" } },
            [
                createElement(
                    "button",
                    {
                        className: "button button-primary",
                        onClick: handleSave,
                        disabled: isSaving,
                    },
                    isSaving ? "Speichern..." : "Speichern"
                ),
                saveMessage && createElement("span", { key: "saved" }, saveMessage),
            ]
        ),
    ]);
}

document.addEventListener("DOMContentLoaded", () => {
    render(createElement(WPVSApp), document.getElementById("wpvs-settings-root"));
});
