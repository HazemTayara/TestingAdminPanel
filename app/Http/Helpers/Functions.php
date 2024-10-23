<?php


function getStatus($status): string
{
    switch ($status) {
        case 'pending':
            return 'bg-gray-500';
        case 'accept':
            return 'bg-green-500';
        case 'done':
            return 'bg-gold-500';
        case 'reject':
            return 'bg-red-500';
        default:
            return 'bg-default';
    }
}
