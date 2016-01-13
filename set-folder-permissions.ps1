param($appPoolName="vmstest")
cls

$folders = @('assets','protected\assets')

foreach($folder in $folders){

    $identity = "IIS AppPool\$appPoolName"
    $fileSystemRights = "FullControl"
    $inheritanceFlags = "ContainerInherit, ObjectInherit"
    $propagationFlags = "None"
    $accessControlType = "Allow"
    $rule = New-Object System.Security.AccessControl.FileSystemAccessRule($identity, $fileSystemRights, $inheritanceFlags, $propagationFlags, $accessControlType)

    $acl = Get-Acl $folder
    $acl.SetAccessRule($rule)
    Set-Acl $folder $acl
}