const { SerialPort } = require('serialport');
const { ReadlineParser } = require('@serialport/parser-readline');
const axios = require('axios');

const port = new SerialPort({
    path: 'COM3', // ajuste para sua porta
    baudRate: 9600
});

const parser = port.pipe(
    new ReadlineParser({ delimiter: '\r\n' })
);

parser.on('data', async (data) => {

    //console.log("Recebido do Arduino:", data);

    const valor = parseInt(data);

    let status = "";

    if (valor <= 200)
        status = "Normal";
    else if (valor <= 500)
        status = "Médio";
    else
        status = "Extremo";

    try {

        const resposta = await axios.post(
            'http://127.0.0.1:8000/api/leitura-atual',
            {
                valor: valor,
                status: status
            }
        );

        console.log("Enviado:", resposta.data);

    } catch (erro) {

        console.error("Erro:", erro.message);

    }

});