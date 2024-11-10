const express = require("express");
const Groq = require("groq-sdk");
const app = express();
//the is no port in the locahost
const PORT = 3000;
const IP = "127.0.0.1";
const cors = require("cors");

const groq = new Groq({
    apiKey: "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",
});
app.use(cors());
app.use(express.json());

// Endpoint to generate event description
app.post("/generate-description", async (req, res) => {
    console.log("AI");
    const { name, location, date, description } = req.body.eventDetails;

    const prompt = `Generate a description for an event with details: Name: ${name}, Location: ${location}, Date: ${date}, Details: ${description}`;
    const model = "llama3-8b-8192";

    try {
        const response = await groq.chat.completions.create({
            messages: [{ role: "user", content: prompt }],
            model: model,
        });

        const generatedDescription = response.choices[0].message.content;
        res.json({ success: true, generatedDescription });
    } catch (error) {
        console.error("Error generating description:", error.message);
        res.status(500).json({
            success: false,
            message: "Failed to generate description",
        });
    }
});

app.listen(PORT, IP, () => {
    console.log(`Node.js server running on http://${IP}:${PORT}`);
});
