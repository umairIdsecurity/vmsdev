param($appPoolName="vmstest")
cls

$folders = @('assets','protected\assets')

function setAccess($folder,$fileSystemRights


    if(!(Test-Path $folder)){
        Write-Host "creating folder $folder"
        New-Item -ItemType directory -Path $folder
    }

    $identity = "IIS AppPool\$appPoolName"
    #$fileSystemRights = "FullControl"
    $inheritanceFlags = "ContainerInherit, ObjectInherit"
    $propagationFlags = "None"
    $accessControlType = "Allow"
    $rule = New-Object System.Security.AccessControl.FileSystemAccessRule($identity, $fileSystemRights, $inheritanceFlags, $propagationFlags, $accessControlType)

    Write-Host "setting permissions on folder $folder for app pool $appPoolName"
    $acl = Get-Acl $folder
    $acl.SetAccessRule($rule)
    Set-Acl $folder $acl
}

setAccess '.' 'Read'
setAccess 'assets' 'FullControl'
setAccess 'protected\assets' 'FullControl'
setAccess 'protected\runtime' 'FullControl'
