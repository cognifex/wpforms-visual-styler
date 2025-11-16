import { createElement, render, useState, useEffect } from '@wordpress/element';
import { ColorGradientSettingsDropdown, useMultipleOriginColorsAndGradients } from '@wordpress/block-editor';

function WPVSApp() {

    const [formId, setFormId] = useState(null);
    const [settings, setSettings] = useState({});

    useEffect(() => {
        // Liste links klickbar machen
        document.querySelectorAll("#wpvs-form-list li").forEach(li => {
            li.onclick = () => {
                const id = li.dataset.id;
                setFormId(id);
                document.getElementById("wpvs-iframe").src = WPVS.previewBase + id;
            };
        });
    }, []);

    // Color Picker Wrapper
    const BlocksyColor = ({field}) => {
        const colorSettings = useMultipleOriginColorsAndGradients();

        return createElement(ColorGradientSettingsDropdown, {
            __experimentalIsRenderedInSidebar: true,
            __experimentalHasMultipleOrigins: true,
            settings: [{
                label: field,
                colorValue: settings[field] || "",
                onColorChange: (v) => {
                    setSettings({...settings, [field]: v});
                    updatePreview();
                }
            }],
            ...colorSettings
        });
    };

    function updatePreview(){
        const iframe = document.getElementById("wpvs-iframe");
        if (!iframe) return;

        let url = WPVS.previewBase + formId + "?" + new URLSearchParams(settings).toString();
        iframe.src = url;
    }

    if (!formId) return "Bitte Formular links auswählen.";

    return createElement("div", {}, [
        createElement("h3", {}, "Style Einstellungen"),

        createElement("h4", {}, "Card"),
        createElement(BlocksyColor, {field:"card_bg"}),
        createElement(BlocksyColor, {field:"card_border"}),

        createElement("h4", {}, "Inputs"),
        createElement(BlocksyColor, {field:"input_bg"}),
        createElement(BlocksyColor, {field:"input_border"}),
        createElement(BlocksyColor, {field:"input_text"}),

        createElement("h4", {}, "Buttons"),
        createElement(BlocksyColor, {field:"btn_bg"}),
        createElement(BlocksyColor, {field:"btn_bg_hov"}),

        createElement("button", {
            className:"button button-primary",
            onClick: () => {
                const data = new FormData();
                data.append("action","wpvs_save");
                data.append("form_id",formId);
                data.append("settings",JSON.stringify(settings));

                fetch(WPVS.ajax, {method:"POST", body:data});
            }
        }, "Speichern")
    ]);
}

document.addEventListener("DOMContentLoaded", () => {
    render(createElement(WPVSApp), document.getElementById("wpvs-settings-root"));
});
