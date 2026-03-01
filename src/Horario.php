<?php

class Horario
{
    private int $hora;
    private int $minuto;
    private int $segundo;

    public function __construct(int $hora = 0, int $minuto = 0, int $segundo = 0)
    {
        $this->set($hora, $minuto, $segundo);
    }

    public static function agora(): self
    {
        $agora = getdate();
        return new self($agora['hours'], $agora['minutes'], $agora['seconds']);
    }

    public static function fromString(string $texto): self
    {
        [$h, $m, $s] = explode(':', $texto);
        return new self((int)$h, (int)$m, (int)$s);
    }

    public function set(?int $hora = null, ?int $minuto = null, ?int $segundo = null): void
    {
        if ($hora !== null) {
            $this->validar($hora, 0, 23);
            $this->hora = $hora;
        }

        if ($minuto !== null) {
            $this->validar($minuto, 0, 59);
            $this->minuto = $minuto;
        }

        if ($segundo !== null) {
            $this->validar($segundo, 0, 59);
            $this->segundo = $segundo;
        }
    }

    public function ajustarVarios(int ...$valores): void
    {
        [$h, $m, $s] = $valores + [0, 0, 0];
        $this->set($h, $m, $s);
    }

    public function tick(int $segundos = 1): void
    {
        $total = $this->hora * 3600 + $this->minuto * 60 + $this->segundo;
        $total += $segundos;

        $total = $total % 86400;

        $this->hora = intdiv($total, 3600);
        $this->minuto = intdiv($total % 3600, 60);
        $this->segundo = $total % 60;
    }

    public function formatar(): string
    {
        return sprintf('%02d:%02d:%02d', $this->hora, $this->minuto, $this->segundo);
    }

    public function comparar(Horario $outro): int|bool
    {
        $atual = $this->hora * 3600 + $this->minuto * 60 + $this->segundo;
        $comparado = $outro->hora * 3600 + $outro->minuto * 60 + $outro->segundo;

        if ($atual === $comparado) {
            return true;
        }

        return $atual <=> $comparado;
    }

    private function validar(int $valor, int $min, int $max): void
    {
        if ($valor < $min || $valor > $max) {
            $this->erro("Valor inválido: $valor");
        }
    }

    private function erro(string $mensagem): never
    {
        throw new InvalidArgumentException($mensagem);
    }
}