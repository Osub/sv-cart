<?
    /**
     * ��� SV-CART ��ǰ������ HTTP Э�鷽ʽ
     */
    function http()
    {
        return (isset($_SERVER['HTTPS']) && (strtolower($_SERVER['HTTPS']) != 'off')) ? 'https://' : 'http://';
    }
    
    /**
     * ȡ�õ�ǰ������
     */
    function get_domain()
    {
        /* Э�� */
        $protocol = http();

        /* ������IP��ַ */
        if (isset($_SERVER['HTTP_X_FORWARDED_HOST']))
        {
            $host = $_SERVER['HTTP_X_FORWARDED_HOST'];
        }
        elseif (isset($_SERVER['HTTP_HOST']))
        {
            $host = $_SERVER['HTTP_HOST'];
        }
        else
        {
            /* �˿� */
            if (isset($_SERVER['SERVER_PORT']))
            {
                $port = ':' . $_SERVER['SERVER_PORT'];

                if ((':80' == $port && 'http://' == $protocol) || (':443' == $port && 'https://' == $protocol))
                {
                    $port = '';
                }
            }
            else
            {
                $port = '';
            }

            if (isset($_SERVER['SERVER_NAME']))
            {
                $host = $_SERVER['SERVER_NAME'] . $port;
            }
            elseif (isset($_SERVER['SERVER_ADDR']))
            {
                $host = $_SERVER['SERVER_ADDR'] . $port;
            }
        }

        return $protocol . $host;
    }

    /**
     * ��� SV-CART ��ǰ������ URL ��ַ
     */
    function url()
    {
        $curr = strpos($_SERVER['PHP_SELF'], 'admin/') !== false ?
                preg_replace('/(.*)(sv-admin)(\/?)(.)*/i', '\1', dirname($_SERVER['PHP_SELF'])) :
                dirname(PHP_SELF);

        $root = str_replace('\\', '/', $curr);

        if (substr($root, -1) != '/')
        {
            $root .= '/';
        }
        return get_domain() . $root;
    }
	
?>