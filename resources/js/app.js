import Chart from 'chart.js/auto';

function iniciarPainel() {
	const canvas = document.getElementById('grafico');
	if (!canvas) return;

	const labels = [];
	const valores = [];
	const chart = new Chart(canvas, {
		type: 'line',
		data: {
			labels,
			datasets: [{
				label: 'Concentração de Gás',
				data: valores,
				borderColor: '#22c55e',
				backgroundColor: 'rgba(34,197,94,.15)',
				tension: 0.35,
				fill: true
			}]
		},
		options: {
			responsive: true,
			plugins: { legend: { display: false } }
		}
	});

	async function atualizarPainel() {
		try {
			const resposta = await fetch('/api/leitura-atual');
			if (!resposta.ok) throw new Error(`HTTP ${resposta.status}`);

			const leitura = await resposta.json();
			document.getElementById('valor').innerText = leitura.valor;
			document.getElementById('status').innerText = leitura.status;
			document.getElementById('hora').innerText = leitura.hora;

			const alertaSpan = document.getElementById('alerta-status');
			if (leitura.valor > 500) {
				alertaSpan.innerText = 'ALERTA DE GÁS';
				alertaSpan.className = 'px-4 py-2 rounded-full bg-red-100 text-red-800 text-sm font-medium alerta-ativo';
			} else if (leitura.valor > 200) {
				alertaSpan.innerText = 'ALERTA DE GÁS';
				alertaSpan.className = 'px-4 py-2 rounded-full bg-yellow-100 text-yellow-800 text-sm font-medium alerta-ativo';
			} else {
				alertaSpan.innerText = 'AMBIENTE LIMPO';
				alertaSpan.className = 'px-4 py-2 rounded-full bg-blue-100 text-blue-800 text-sm font-medium';
			}

			labels.push(leitura.hora);
			valores.push(leitura.valor);
			if (labels.length > 20) {
				labels.shift();
				valores.shift();
			}

			chart.update();
		} catch (erro) {
			console.error('Erro ao atualizar painel:', erro);
		}
	}

	atualizarPainel();
	setInterval(atualizarPainel, 1000);
}

function iniciarRelatorio() {
	const canvas = document.getElementById('grafico');
	const filtro = document.getElementById('filtro-periodo');
	if (!canvas || !filtro) return;

	let periodoAtual = 'dia';
	const labels = [];
	const valores = [];
	const chart = new Chart(canvas, {
		type: 'bar',
		data: {
			labels,
			datasets: [{
				label: 'Concentração de Gás (PPM)',
				data: valores,
				backgroundColor: ['#3b82f6'],
				borderColor: ['#2563eb'],
				borderWidth: 2,
				borderRadius: 8,
				borderSkipped: false
			}]
		},
		options: {
			responsive: true,
			plugins: {
				legend: {
					display: true,
					position: 'top',
					labels: {
						usePointStyle: false,
						boxWidth: 30,
						boxHeight: 12,
						padding: 12,
						generateLabels: () => [
							{ text: 'Normal', fillStyle: '#22c55e', strokeStyle: '#22c55e', lineWidth: 0, hidden: false, index: 0 },
							{ text: 'Alerta', fillStyle: '#f59e0b', strokeStyle: '#f59e0b', lineWidth: 0, hidden: false, index: 1 },
							{ text: 'Crítico', fillStyle: '#dc2626', strokeStyle: '#dc2626', lineWidth: 0, hidden: false, index: 2 }
						]
					}
				}
			},
			scales: {
				y: {
					beginAtZero: true,
					max: 1000,
					ticks: { callback: value => `${value} PPM` }
				}
			}
		}
	});

	function corPorValor(valor) {
		if (valor > 500) return '#dc2626';
		if (valor > 200) return '#f59e0b';
		return '#22c55e';
	}

	async function carregarRelatorio() {
		try {
			const resposta = await fetch(`/api/relatorio?periodo=${periodoAtual}`);
			if (!resposta.ok) throw new Error(`HTTP ${resposta.status}`);

			const dados = await resposta.json();
			labels.length = 0;
			valores.length = 0;

			dados.forEach(item => {
				labels.push(item.periodo);
				valores.push(item.valor);
			});

			chart.data.labels = labels;
			chart.data.datasets[0].data = valores;
			chart.data.datasets[0].backgroundColor = valores.map(corPorValor);
			chart.data.datasets[0].borderColor = valores.map(corPorValor);
			chart.update();
		} catch (erro) {
			console.error('Erro ao carregar relatório:', erro);
		}
	}

	filtro.addEventListener('change', () => {
		periodoAtual = filtro.value;
		carregarRelatorio();
	});

	carregarRelatorio();
}

iniciarPainel();
iniciarRelatorio();
