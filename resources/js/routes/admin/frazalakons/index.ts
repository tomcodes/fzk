import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see routes/web.php:196
* @route '/admin/frazalakons/{frazalakon}'
*/
export const update = (args: { frazalakon: string | { slug: string } } | [frazalakon: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/admin/frazalakons/{frazalakon}',
} satisfies RouteDefinition<["put"]>

/**
* @see routes/web.php:196
* @route '/admin/frazalakons/{frazalakon}'
*/
update.url = (args: { frazalakon: string | { slug: string } } | [frazalakon: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { frazalakon: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'slug' in args) {
        args = { frazalakon: args.slug }
    }

    if (Array.isArray(args)) {
        args = {
            frazalakon: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        frazalakon: typeof args.frazalakon === 'object'
        ? args.frazalakon.slug
        : args.frazalakon,
    }

    return update.definition.url
            .replace('{frazalakon}', parsedArgs.frazalakon.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see routes/web.php:196
* @route '/admin/frazalakons/{frazalakon}'
*/
update.put = (args: { frazalakon: string | { slug: string } } | [frazalakon: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see routes/web.php:196
* @route '/admin/frazalakons/{frazalakon}'
*/
const updateForm = (args: { frazalakon: string | { slug: string } } | [frazalakon: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see routes/web.php:196
* @route '/admin/frazalakons/{frazalakon}'
*/
updateForm.put = (args: { frazalakon: string | { slug: string } } | [frazalakon: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: update.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

update.form = updateForm

/**
* @see routes/web.php:212
* @route '/admin/frazalakons/{frazalakon}'
*/
export const destroy = (args: { frazalakon: string | { slug: string } } | [frazalakon: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/admin/frazalakons/{frazalakon}',
} satisfies RouteDefinition<["delete"]>

/**
* @see routes/web.php:212
* @route '/admin/frazalakons/{frazalakon}'
*/
destroy.url = (args: { frazalakon: string | { slug: string } } | [frazalakon: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { frazalakon: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'slug' in args) {
        args = { frazalakon: args.slug }
    }

    if (Array.isArray(args)) {
        args = {
            frazalakon: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        frazalakon: typeof args.frazalakon === 'object'
        ? args.frazalakon.slug
        : args.frazalakon,
    }

    return destroy.definition.url
            .replace('{frazalakon}', parsedArgs.frazalakon.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see routes/web.php:212
* @route '/admin/frazalakons/{frazalakon}'
*/
destroy.delete = (args: { frazalakon: string | { slug: string } } | [frazalakon: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

/**
* @see routes/web.php:212
* @route '/admin/frazalakons/{frazalakon}'
*/
const destroyForm = (args: { frazalakon: string | { slug: string } } | [frazalakon: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see routes/web.php:212
* @route '/admin/frazalakons/{frazalakon}'
*/
destroyForm.delete = (args: { frazalakon: string | { slug: string } } | [frazalakon: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: destroy.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

destroy.form = destroyForm

/**
* @see routes/web.php:218
* @route '/admin/frazalakons/{frazalakon}/publish'
*/
export const publish = (args: { frazalakon: string | { slug: string } } | [frazalakon: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: publish.url(args, options),
    method: 'post',
})

publish.definition = {
    methods: ["post"],
    url: '/admin/frazalakons/{frazalakon}/publish',
} satisfies RouteDefinition<["post"]>

/**
* @see routes/web.php:218
* @route '/admin/frazalakons/{frazalakon}/publish'
*/
publish.url = (args: { frazalakon: string | { slug: string } } | [frazalakon: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { frazalakon: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'slug' in args) {
        args = { frazalakon: args.slug }
    }

    if (Array.isArray(args)) {
        args = {
            frazalakon: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        frazalakon: typeof args.frazalakon === 'object'
        ? args.frazalakon.slug
        : args.frazalakon,
    }

    return publish.definition.url
            .replace('{frazalakon}', parsedArgs.frazalakon.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see routes/web.php:218
* @route '/admin/frazalakons/{frazalakon}/publish'
*/
publish.post = (args: { frazalakon: string | { slug: string } } | [frazalakon: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: publish.url(args, options),
    method: 'post',
})

/**
* @see routes/web.php:218
* @route '/admin/frazalakons/{frazalakon}/publish'
*/
const publishForm = (args: { frazalakon: string | { slug: string } } | [frazalakon: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: publish.url(args, options),
    method: 'post',
})

/**
* @see routes/web.php:218
* @route '/admin/frazalakons/{frazalakon}/publish'
*/
publishForm.post = (args: { frazalakon: string | { slug: string } } | [frazalakon: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: publish.url(args, options),
    method: 'post',
})

publish.form = publishForm

const frazalakons = {
    update: Object.assign(update, update),
    destroy: Object.assign(destroy, destroy),
    publish: Object.assign(publish, publish),
}

export default frazalakons